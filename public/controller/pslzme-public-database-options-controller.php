<?php

/**
 * Class that is responsible for handling database operations that are used for public site requests.
 */
class PslzmePublicDatabaseOptionsController {

    private $connection;

    /**
     * constructor
     * @connection Database connection created by PslzmeDatabaseConnection class located in /includes/pslzme-database-connection.php
     */
    public function __construct($connection) {
        $this->connection = $connection;
    }


    /**
     * This function selects the current customers ID and encryption key.
     * @return an array containing the customers ID encryption key and encryption ID.
     * @throws DatabaseException When on of the declared statements cannot be executed.
     */
    public function select_customer_with_key() {
        // Get the only customer row (assuming one)
        $selectPslzmeCustomerStmt = PslzmePreparedStmtFactory::prepare_select_all_pslzme_customer_stmt();
        $customerResult = $this->connection->get_row($selectPslzmeCustomerStmt);

        if (!$customerResult) {
            throw new DatabaseException("Unable to extract customer ID out of database");
        }

        $customerID = $customerResult->KundenID;

        // Prepare query to get encryption key for this customer
        $selectPslzmeCustomerKeyStmt = PslzmePreparedStmtFactory::prepare_select_pslzme_customer_key_stmt();
        $preparedSelectKeyStmt = $this->connection->prepare($selectPslzmeCustomerKeyStmt, $customerID);

        $keyResult = $this->connection->get_row($preparedSelectKeyStmt);

        if (!$keyResult) {
            throw new DatabaseException("Unable to extract customer key and ID out of database. Query: " . $preparedSelectKeyStmt);
        }

        $encryptionID = $keyResult->EncryptionID;
        $encryptionKey = $keyResult->EncryptionKey;

        return [
            "customerID"    => $customerID,
            "encryptionID"  => $encryptionID,
            "encryptionKey" => $encryptionKey
        ];
    }


    /**
     * This function checks if a query / pslzme link has been accepted by a customer or not.
     * @customerID The customers ID.
     * @encryptionID The customers encryption ID.
     * @timestamp A timestamp that is located in the pslzme URL parameters.
     * @return an array containing cookieAccepted param that declares if the cookie has been accepted and queryLocked param that declares if the query has been locked already.
     * @throws InvalidDataException When one of the function parameters does not exist.
     */
    public function select_pslzme_query_acceptance($customerID, $encryptionID, $timestamp) {
        if (!$customerID || !$encryptionID || !$timestamp) {
            throw new InvalidDataException("Params for select_pslzme_query_acceptance uncomplete! Params: " . $customerID . " " . $encryptionID . " " . $timestamp);
        }
        
        // select the query by params
        $selectQueryStmt = PslzmePreparedStmtFactory::prepare_select_pslzme_query_for_customer();
        $preparedSelectQueryStmt = $this->connection->prepare($selectQueryStmt, $timestamp, $customerID, $encryptionID);
        $selectQueryStmtRslt = $this->connection->get_row($preparedSelectQueryStmt);

        if (!$selectQueryStmtRslt) {
            // no query found 
            return null;
        }

        $cookieAccepted = $selectQueryStmtRslt->Accepted;
        $queryLocked = $selectQueryStmtRslt->Locked;

        return [
            "cookieAccepted" => $cookieAccepted,
            "queryLocked"    => $queryLocked
        ];

    }


    /**
     * Remove because not needed anymore?
     */
    public function select_query_acceptance($data) {
        $customerID = $data["customerID"];
        if ($customerID === null) {
            throw new InvalidDataException("Unable to extract customer ID out of data object");
        }

        $encryptID = $data["encryptID"];
        if ($encryptID === null) {
            throw new InvalidDataException("Unable to extract encryption ID out of data object");
        }

        $timestamp = $data["timestamp"];
        if ($timestamp === null) {
            throw new InvalidDataException("Unable to extract timestamp out of data object");
        }

        // select the query by params
        $selectQueryStmt = PslzmePreparedStmtFactory::prepare_select_pslzme_query_for_customer();
        $preparedSelectQueryStmt = $this->connection->prepare($selectQueryStmt, $timestamp, $customerID, $encryptID);
        $selectQueryStmtRslt = $this->connection->get_row($preparedSelectQueryStmt);

        if (!$selectQueryStmtRslt) {
            throw new DatabaseException("No query found for customer ID " . $customerID . " and encrypt ID " . $encryptID . " at timestamp " . $timestamp);
        }

        $cookieAccepted = $selectQueryStmtRslt->Accepted;

        return ["cookieAccepted" => $cookieAccepted];
    }

    /**
     * This function inserts a new pslzme link into the database.
     * @data Array containing all information that is needed for a pslzme link like the URL parameters as query.
     * @throws InvalidDataException When one of the needed parameters inside the data array does not exist.
     * @throws DatabaseException When on of the used statements cannot be executed. 
     */
    public function insert_pslzme_query_data($data) {
        $query = $data["query"];
        if ($query === null) {
            throw new InvalidDataException("Unable to extract query out of data object");
        }

        $timestamp = $data["timestamp"];
        if ($timestamp === null) {
            throw new InvalidDataException("Unable to extract timestamp out of data object");
        }

        $acceptedOn = $data["acceptedOn"];
        if ($acceptedOn === null) {
            throw new InvalidDataException("Unable to extract acception time out of data object");
        }

        $queryLocked = $data["queryLocked"];
        if ($queryLocked === null) {
            throw new InvalidDataException("Unable to extract query locked out of data object");
        }

        $cookieAccepted = $data["cookieAccepted"];
        if ($cookieAccepted === null) {
            throw new InvalidDataException("Unable to extract cookie acception out of data object");
        }

        $customerID = $data["customerID"];
        if ($customerID === null) {
            throw new InvalidDataException("Unable to extract customer ID out of data object");
        }

        $encryptID = $data["encryptID"];
        if ($encryptID === null) {
            throw new InvalidDataException("Unable to extract encryption ID out of data object");
        }

        // first check if the query already exists -> user has declined or accepted the cookie before
        $selectPslzmeQueryStmt = PslzmePreparedStmtFactory::prepare_select_pslzme_query_stmt();
        $preparedPslzmeQueryStmt = $this->connection->prepare($selectPslzmeQueryStmt, $timestamp, $customerID, $encryptID);
        $selectPslzmeQueryRslt = $this->connection->get_row($preparedPslzmeQueryStmt);

        if (!$selectPslzmeQueryRslt) {
            // the query is not present -> insert new query
            $insertPslzmeQueryStmt = PslzmePreparedStmtFactory::prepare_insert_pslzme_query_stmt();
            $preparedInsertStmt = $this->connection->prepare($insertPslzmeQueryStmt, $query, $timestamp, $acceptedOn, $cookieAccepted, $queryLocked, $customerID, $encryptID);
            $insertStmtRslt = $this->connection->query($preparedInsertStmt);

             if ($insertStmtRslt === false) {
                throw new DatabaseException('Insert failed: ' . $this->connection->last_error);
            }
        } else {
            // query is present and must be overwritten
            $updatePslzmeQueryStmt = PslzmePreparedStmtFactory::prepare_update_pslzme_query_stmt();
            $preparedUpdateStmt = $this->connection->prepare($updatePslzmeQueryStmt, $cookieAccepted, $queryLocked, $acceptedOn, $timestamp, $customerID, $encryptID);
            $updateStmtRslt = $this->connection->query($preparedUpdateStmt);

            if ($updateStmtRslt === false) {
                throw new DatabaseException("Update failed: " . $this->connection->last_error);
            }
        }
    }
}

?>
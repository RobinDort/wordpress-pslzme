<?php

class PslzmePublicDatabaseOptionsController {

    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }


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
            $preparedInsertStmt = $this->connection->prepare($insertPslzmeQueryStmt, $query, $timestamp, $acceptedOn, $cookieAccepted, $customerID, $encryptID, $queryLocked);
            $insertStmtRslt = $this->connection->query($preparedInsertStmt);

             if ($insertStmtRslt === false) {
                throw new DatabaseException('Insert failed: ' . $this->connection->last_error);
            }
        } else {
            // query is present and must be overwritten
            $updatePslzmeQueryStmt = PslzmePreparedStmtFactory::prepare_update_pslzme_query_stmt();
            $preparedUpdateStmt = $this->connection->prepare($updatePslzmeQueryStmt, $timestamp, $acceptedOn, $cookieAccepted, $customerID, $encryptID, $queryLocked);
            $updateStmtRslt = $this->connection->query($preparedUpdateStmt);

            if ($updateStmtRslt === false) {
                throw new DatabaseException("Update failed: " . $this->connection->last_error);
            }
        }
    }
}

?>
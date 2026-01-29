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
}

?>
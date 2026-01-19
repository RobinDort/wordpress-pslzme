<?php

class PslzmeAdminDatabaseOptionsController {

    private $dbConnection;

    public function __construct() {
        // Connect to the new database with the credentials given from the pslzme admin settings panel
        $options = get_option('pslzme_settings', []);
        $pslzmeDBConnection = new PslzmeAdminDatabaseConnection($options);
        $this->dbConnection = $pslzmeDBConnection->get_connection();
    }

    public function handle_create_pslzme_tables() {

        $options = get_option('pslzme_settings', []);
        $encryptedPassword = $options['db_password'] ?? '';

        $pslzmeDBConnection = new PslzmeAdminDatabaseConnection($options);
        
        try {
            //create all needed pslzme tables by using the factory methods
            $createPslzmeCustomerTableStmt = PslzmeAdminPreparedStmtFactory::prepare_create_pslzme_customer_table_stmt();
            $createEncryptionInfoTableStmt = PslzmeAdminPreparedStmtFactory::prepare_create_pslzme_encryption_info_table_stmt();       
            $createQueryLinkTableStmt = PslzmeAdminPreparedStmtFactory::prepare_create_pslzme_query_link_table_stmt();


            $errors = [];
            $createCustomerTableSuccess = $this->dbConnection->query($createPslzmeCustomerTableStmt);
            if ($createCustomerTableSuccess === false || $this->dbConnection->last_error !== '') {
                $errors[] = $this->dbConnection;
            }

            $this->dbConnection->query($createEncryptionInfoTableStmt);
            if ($this->dbConnection->last_error !== '') {
                $errors[] = 'encrypt_info: ' . $this->dbConnection->last_error;
            }

            $this->dbConnection->query($createQueryLinkTableStmt);
            if ($this->dbConnection->last_error !== '') {
                $errors[] = 'query_link: ' . $this->dbConnection->last_error;
            }

            if (!empty($errors)) {
                wp_send_json_error([$errors]);
            } else {
                wp_send_json_success(['message' => "Tabellen erfolgreich erstellt."]);
            }
        } catch (Exception $e) {
            wp_send_json_error(['message' => 'Exception beim Erstellen der Tabellen: ' . $e->getMessage()]);
        } finally {
            // Close the database connection
            $this->dbConnection->close_connection();
        }

    }
}
?>
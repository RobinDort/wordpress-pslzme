<?php

class PslzmeAdminDatabaseOptionsController {

    private $dbConnection;

    public function __construct() {
        // Connect to the new database with the credentials given from the pslzme admin settings panel
        $options = get_option('pslzme_settings', []);
        $pslzmeDBConnection = new PslzmeDatabaseConnection($options);
        $this->dbConnection = $pslzmeDBConnection->get_connection();
    }

    public function handle_create_pslzme_tables() {
        
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
                // update options accordingly to set this step to true
                $options = get_option("pslzme_settings", []);
                $options["tables_configured"] = true;
                update_option("pslzme_settings", $options);

                wp_send_json_success(['message' => "Tabellen erfolgreich erstellt."]);
            }
        } catch (Exception $e) {
            wp_send_json_error(['message' => 'Exception beim Erstellen der Tabellen: ' . $e->getMessage()]);
        } finally {
            // Close the database connection
            $this->dbConnection->close_connection();
        }
    }

    public function handle_register_customer() {
        $data = isset($_POST['data']) ? json_decode(stripslashes($_POST['data']), true) : null;

		if (!$data || empty($data['customer']) || empty($data['key'])) {
			wp_send_json_error(['message' => 'Missing customer or key'], 400);
		}
        $customer = sanitize_text_field($data['customer']);
        $key      = sanitize_text_field($data['key']);

        try {

            $selectPslzmeCustomerStmt = PslzmeAdminPreparedStmtFactory::prepare_select_pslzme_customer_stmt();
            $preparedSelectStmt = $this->dbConnection->prepare($selectPslzmeCustomerStmt, $customer);
            $customerID = $this->dbConnection->get_var($preparedSelectStmt);

            if ($customerID) {
                wp_send_json_error(["message" => "Customer already saved"]);
            } else {
                $insertCustomerStmt = $this->dbConnection->insert("pslzme_kunde", ["Name" => $customer], ["%s"]);

                if ($insertCustomerStmt === false) {
                    wp_send_json_error(['message' => 'Customer insert failed']);
                }

                $customerID = $this->dbConnection->insert_id;
                $insertKeyStmt = $this->dbConnection->insert("encrypt_info", ["EncryptionKey" => $key, "PslzmeKundenID" => $customerID], ["%s", "%d"]);

                if ($insertKeyStmt === false) {
                    wp_send_json_error(["message" => "Encryption key insert failed"]);
                }

                wp_send_json_success("Domain registration successful");
            }


        } catch (Exception $e) {
           wp_send_json_error(['message' => 'Exception beim Registrieren der Domain: ' . $e->getMessage()]);
        }

        // update options accordingly to set this step to true
		$options = get_option("pslzme_settings", []);
		$options["url_licensed"] = true;
		update_option("pslzme_settings", $options);

        wp_send_json_success(["message" => "Data reveived: " . $customer . $key]);
    }
}
?>
<?php

/**
 * Class that handles admin side related database functionality.
 */
class PslzmeAdminDatabaseOptionsController {

    private $dbConnection;

    /**
     * 
     * constructor.
     * @var dbConnection Database connection created by PslzmeDatabaseConnection class located in /includes/pslzme-database-connection.php
     * 
     */
    public function __construct() {
        // Connect to the new database with the credentials given from the pslzme admin settings panel
        $options = get_option('pslzme_settings', []);
        $pslzmeDBConnection = new PslzmeDatabaseConnection($options);
        $this->dbConnection = $pslzmeDBConnection->get_connection();
    }


    /**
     * 
     * This function creates new tables for the customers pslzme database by using predefined statements.
     * @throws Exception When one or more of the tables could not been created.
     * 
     */
    public function handle_create_pslzme_tables() {
        
        try {
            //create all needed pslzme tables by using the factory methods
            $createPslzmeCustomerTableStmt = PslzmePreparedStmtFactory::prepare_create_pslzme_customer_table_stmt();
            $createEncryptionInfoTableStmt = PslzmePreparedStmtFactory::prepare_create_pslzme_encryption_info_table_stmt();       
            $createQueryLinkTableStmt = PslzmePreparedStmtFactory::prepare_create_pslzme_query_link_table_stmt();


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
                update_option("pslzme_tables_configured", true);

                wp_send_json_success(['message' => "Tabellen erfolgreich erstellt."]);
            }
        } catch (Exception $e) {
            wp_send_json_error(['message' => 'Exception beim Erstellen der Tabellen: ' . $e->getMessage()]);
        }
    }

    /**
     * 
     * This function inserts a new customer with its generated encrypted ID into the customers pslzme database.
     * The function is used to register the active domain under pslzme.com. Domain registration is required to use this plugin. 
     * 
     */
    public function handle_register_customer() {
        $data = isset($_POST['data']) ? json_decode(stripslashes($_POST['data']), true) : null;

		if (!$data || empty($data['customer']) || empty($data['key'] || empty($data['apiKey']))) {
			wp_send_json_error(['message' => 'Missing customer or key'], 400);
		}
        $customer = sanitize_text_field($data['customer']);
        $key      = sanitize_text_field($data['key']);
        $apiKey   = sanitize_text_field($data['apiKey']);

        try {

            $selectPslzmeCustomerStmt = PslzmePreparedStmtFactory::prepare_select_pslzme_customer_by_name_stmt();
            $preparedSelectStmt = $this->dbConnection->prepare($selectPslzmeCustomerStmt, $customer);
            $customerID = $this->dbConnection->get_var($preparedSelectStmt);

            if ($customerID) {
                wp_send_json_error(["message" => "Customer already saved"]);
            } else {
                $insertCustomerStmt = $this->dbConnection->insert("pslzme_kunde", ["Name" => $customer, "ApiKey" => $apiKey], ["%s", "%s"]);

                if ($insertCustomerStmt === false) {
                    wp_send_json_error(['message' => 'Customer insert failed']);
                }

                update_option("pslzme_api_key", $apiKey);

                $customerID = $this->dbConnection->insert_id;
                $insertKeyStmt = $this->dbConnection->insert("encrypt_info", ["EncryptionKey" => $key, "PslzmeKundenID" => $customerID], ["%s", "%d"]);

                if ($insertKeyStmt === false) {
                    wp_send_json_error(["message" => "Encryption key insert failed"]);
                }
                // update options accordingly to set this step to true
                update_option("pslzme_url_licensed", true);

                wp_send_json_success("Domain registration successful");

            }


        } catch (Exception $e) {
           wp_send_json_error(['message' => 'Exception beim Registrieren der Domain: ' . $e->getMessage()]);
        }
    }
}
?>
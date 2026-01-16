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
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        // create all needed pslzme tables by using the factory methods
        $createPslzmeCustomerTableStmt = PslzmeAdminPreparedStmtFactory::prepare_create_pslzme_customer_table_stmt();
        $createEncryptionInfoTableStmt = PslzmeAdminPreparedStmtFactory::prepare_create_pslzme_encryption_info_table_stmt();       
        $createQueryLinkTableStmt = PslzmeAdminPreparedStmtFactory::prepare_create_pslzme_query_link_table_stmt();

        $this->dbConnection->query($createPslzmeCustomerTableStmt);
        if ($this->dbConnection->last_error !== '') {
            wp_send_json_error(['message' => 'Fehler beim Erstellen der Tabelle pslzme_kunde: ' . $this->dbConnection->last_error]);
        }

        $this->dbConnection->query($createEncryptionInfoTableStmt);
        if ($this->dbConnection->last_error !== '') {
            wp_send_json_error(['message' => 'Fehler beim Erstellen der Tabelle encrypt_info: ' . $this->dbConnection->last_error]);
        }

        $this->dbConnection->query($createQueryLinkTableStmt);
        if ($this->dbConnection->last_error !== '') {
            wp_send_json_error(['message' => 'Fehler beim Erstellen der Tabelle query_link: ' . $this->dbConnection->last_error]);
        }

        wp_send_json_success(['message' => 'Alle Tabellen wurden erfolgreich erstellt.']);

    }
}
?>
<?php

class PslzmeAdminDatabaseOptionsController {

    public function __construct() {
        // Connect to the new database with the credentials given from the pslzme admin settings panel
        $options = get_option('pslzme_settings', []);
        $pslzmeDBConnection = new PslzmeAdminDatabaseConnection($options);
    }

    public function handle_create_pslzme_tables() {
        global $wpdb;

        $charset_collate = $wpdb->get_charset_collate();

        //create new table 
    }
}
?>
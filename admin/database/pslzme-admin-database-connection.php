<?php
class PslzmeAdminDatabaseConnection{

    private $connection;

    public function __construct($dbOptions) {
        $host = "localhost";
        $dbname = $dbOptions['db_name'] ?? '';
        $username = $dbOptions['db_user'] ?? '';

        $encryptedPassword = $dbOptions['db_password'] ?? '';
        $decryptedPassword = PslzmeAdminCryptoService::decrypt($encryptedPassword);

        $this->connection = new wpdb($username, $decryptedPassword, $dbname, $host);

        if ($this->connection->last_error !== '') {
            wp_send_json_error(['message' => 'Fehler beim Verbinden mit der Datenbank: ' . $this->connection->last_error]);
        }
    }

    public function get_connection() {
        return $this->connection;
    }

    public function close_connection() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}

?>
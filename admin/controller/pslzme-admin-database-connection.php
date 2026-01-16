<?php
class PslzmeAdminDatabaseConnection{

    private $connection;

    public function __construct($dbOptions) {
        $host = "localhost";
        $dbname = $dbOptions['db_name'] ?? '';
        $username = $dbOptions['db_user'] ?? '';
        $createdAtTimestamp = $dbOptions['created_at'] ?? '';
        $encryptedPassword = $dbOptions['db_password'] ?? '';
        $decryptedPassword = $this->decrypt_password($encryptedPassword, $createdAtTimestamp);

        $this->connection = new wpdb($username, $decryptedPassword, $dbname, $host);

        if ($connection->last_error !== '') {
            wp_send_json_error(['message' => 'Fehler beim Verbinden mit der Datenbank: ' . $connection->last_error]);
        }
    }


    private function decrypt_password($encryptedPassword, $timestamp) {
        $secretKey = hash('sha256', $timestamp, true); 
        $data = base64_decode($encryptedPassword);

        $iv = substr($data, 0, 16);
        $ciphertext = substr($data, 16);
        $decryptedPW = openssl_decrypt($ciphertext, 'aes-256-cbc', $secretKey, 0, $iv);

        return $decryptedPW;
    }


    public function get_connection() {
        return $this->connection;
    }
}

?>
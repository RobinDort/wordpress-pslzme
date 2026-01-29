<?php
class PslzmeDatabaseConnection {

    private $connection;

    public function __construct($dbOptions) {
        $host = "localhost";
        $dbname = $dbOptions['db_name'] ?? '';
        $username = $dbOptions['db_user'] ?? '';

        $encryptedPassword = $dbOptions['db_password'] ?? '';
        $decryptedPassword = PslzmeAdminCryptoService::decrypt($encryptedPassword);

        $this->connection = new wpdb($username, $decryptedPassword, $dbname, $host);

        if (!empty($this->connection->last_error)) {
            throw new Exception(
                'Database connection error: ' . $this->connection->last_error
            );
        }
    }

    public function start_transaction() {
        $this->connection->query("START TRANSACTION");
    }

    public function commit_transaction() {
        $this->connection->query("COMMIT");
    }

    public function rollback_transaction() {
        $this->connection->query("ROLLBACK");
    }

    public function get_connection() {
        return $this->connection;
    }
}

?>
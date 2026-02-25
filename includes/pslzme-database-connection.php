<?php

/**
 * Class that handles the database connection to the database that is created for pslzme by the customer.
 */
class PslzmeDatabaseConnection {

    private $connection;

    /**
     * constructor.
     * @dbOptions An array retrieved by the wordpress database containing information to connect to the new database.
     * @throws DatabaseException When the connection could not be established.
     */
    public function __construct($dbOptions) {

        $host = "localhost";
        $dbname = $dbOptions['db_name'] ?? '';
        $username = $dbOptions['db_user'] ?? '';
        $password = $dbOptions['db_password'] ?? '';

        $this->connection = new wpdb($username, $password, $dbname, $host);

        if (!empty($this->connection->last_error)) {
            throw new DatabaseException(
                'Database connection error: ' . $this->connection->last_error
            );
        }
    }

    /**
     * This function returns the established connection.
     */
    public function get_connection() {
        return $this->connection;
    }
}

?>
<?php

/**
 * Exception that is used for all kinds of database related error.
 */
class DatabaseException extends \Exception {
    public function __construct($message, $code = 0, \Exception $previous = null ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * This functions prints the error text of the exception.
     */
    public function get_error_msg() {
        return "[DatabaseException] Error: " . $this->getMessage();
    }
}

?>
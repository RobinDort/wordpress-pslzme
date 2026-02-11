<?php

/**
 * Exception that is used when data inside API functions cannot be extracted or does not exist.
 */
class InvalidDataException extends \Exception {
    public function __construct($message, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * This functions prints the error text of the exception.
     */
    public function get_error_msg() {
        return "[InvalidDataException] Error: " . $this->getMessage();
    }
}

?>
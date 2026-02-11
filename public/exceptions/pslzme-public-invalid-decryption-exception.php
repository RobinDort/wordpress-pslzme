<?php

/**
 * Exception that is used when decryption of any kind of data fails.
 */
class InvalidDecryptionException extends \Exception {
    public function __construct($message, $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * This function prints the error text of the exception.
     */
    public function get_error_msg() {
        return "[InvalidDecryptionException] Error: " . $this->getMessage();
    }
}

?>
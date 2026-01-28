<?php

class PslzmePublicAPI {
    private $db;
    private $sqlExecutor;

    private $ciphering;
    private $ivLength;
    private $options;


    public function __construct() {
        $options = get_option('pslzme_settings', []);
        $this->db = new PslzmeDatabaseConnection($options);

        $this->ciphering = "AES-128-CTR";
        $this->ivLength = openssl_cipher_iv_length($this->ciphering);
        $this->options = 0;
    }
}

?>
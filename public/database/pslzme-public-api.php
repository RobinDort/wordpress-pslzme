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

    public function handle_query_acception($requestData) {} 

    public function handle_query_lock_check($requestData){}

    public function handle_greeting_data_extraction($requestData) {}

    public function handle_compare_link_owner($requestData) {}


    private function compare_strings($str1, $str2) {
        // Convert both strings to lowercase
        $strToLower1 = mb_strtolower($str1, "UTF-8");
        $strToLower2 = mb_strtolower($str2, "UTF-8");
    
        // Get the lengths of the strings
        $len1 = strlen($strToLower1);
        $len2 = strlen($strToLower2);
    
        // Check if the lengths are at least 3 characters
        if ($len1 < 3 || $len2 < 3) {
            return false;
        }
    
        // Compare the first 3 characters
        for ($i = 0; $i < 3; $i++) {
            $currentCharOfStr1 = mb_substr($strToLower1,$i,1);
            $currentCharOfStr2 = mb_substr($strToLower2,$i,1);
            if ($currentCharOfStr1 !== $currentCharOfStr2) {
                return false;
            }
        }
    
        // If all characters match, return true
        return true;
    }
}

?>
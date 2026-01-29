<?php

class PslzmePublicAPI {

    private $dbConnection;
    private $sqlExecutor;

    private $ciphering;
    private $ivLength;
    private $options;

    private $logger;


    public function __construct() {
        $options = get_option('pslzme_settings', []);
        $pslzmeDBConnection = new PslzmeDatabaseConnection($options);

        $this->dbConnection = $pslzmeDBConnection->get_connection();
        $this->ciphering = "AES-128-CTR";
        $this->ivLength = openssl_cipher_iv_length($this->ciphering);
        $this->options = 0;

        $this->logger = PslzmeLogger::get_instance();

    }

    public function handle_query_acception($requestData) {} 

    public function handle_query_lock_check($requestData){
        $requestData = json_decode($requestData);
        $timestamp = $requestData->timestamp;

        $response = array(
            'msg' => "",
            'queryIsLocked' => false
        );

        try {
            $databaseOptionsController = new PslzmePublicDatabaseOptionsController($this->dbConnection);
            $customerInfo = $databaseOptionsController->select_customer_with_key();

            $customerID = $customerInfo["customerID"];
            $encryptID = $customerInfo["encryptionID"];

            $queryAcceptanceInfo = $databaseOptionsController->select_pslzme_query_acceptance($customerID, $encryptID, $timestamp);

            if ($queryAcceptanceInfo !== null) {
                $queryLocked = $queryAcceptanceInfo["queryLocked"];
                $response["queryIsLocked"] = $queryLocked;
            }
            

        } catch (InvalidDataException $ide) {
            $this->logger->error($ide->get_error_msg());
            $response["msg"] = $ide->get_error_msg();

        } catch (DatabaseException $dbe) {
            $this->logger->error($dbe->get_error_msg());
            $response["msg"] = $dbe->get_error_msg();

        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            $response["msg"] = $e->getMessage();
        }

        return $response;
    }

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
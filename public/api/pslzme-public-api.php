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

    public function handle_query_acception($requestData) {
        $requestData = json_decode($requestData);

        $linkCreator = $requestData->linkCreator;
        $title = $requestData->title;
        $firstname = $requestData->firstname;
        $lastname = $requestData->lastname;
        $company = $requestData->company;
        $companyGender = $requestData->companyGender;
        $gender = $requestData->gender;
        $address = $requestData->address;
        $housenumber = $requestData->housenumber;
        $postcode = $requestData->postcode;
        $place = $requestData->place;
        $country = $requestData->country;
        $position = $requestData->position;
        $curl = $requestData->curl;
        $fc = $requestData->fc;
        $cookieAccepted = $requestData->cookieAccepted;
        $timestamp = $requestData->timestamp;
        $acceptedOn = time();

        $queryLocked = $requestData->queryIsLocked;

        try {
            $databaseOptionsController = new PslzmePublicDatabaseOptionsController($this->dbConnection);
            $customerInfo = $databaseOptionsController->select_customer_with_key();

            $customerID = $customerInfo["customerID"];
            $encryptID = $customerInfo["encryptionID"];

            $insertQueryData = array(
                "query" => "?q1=" . $linkCreator . "&q2=" . $title . "&q3=" . $firstname . "&q4=" . $lastname . "&q5=" . $company . "&q6=" . $gender . "&q7=" . $position . "&q8=" . $curl . "&q9=" . $fc . "&q10=" . $timestamp . "&q11=" . $companyGender . "&q12=" . $address . "&q13=" . $housenumber . "&q14=" . $postcode . "&q15=" . $place . "&q16=" . $country,
                "timestamp" => $timestamp,
                "acceptedOn" => $acceptedOn,
                "cookieAccepted" => $cookieAccepted,
                "queryLocked" => $queryLocked,
                "customerID" => $customerID,
                "encryptID" => $encryptID
            );

            $this->dbConnection->start_transaction();
            $databaseOptionsController->insert_pslzme_query_data($insertQueryData);
            $this->dbConnection->commit_transaction();


        } catch (InvalidDataException $ide) {
            $this->dbConnection->rollback_transaction();
            $this->logger->error($ide->get_error_msg());
            $response["msg"] = $ide->get_error_msg();

        } catch (DatabaseException $dbe) {
            $this->dbConnection->rollback_transaction();
            $this->logger->error($dbe->get_error_msg());
            $response["msg"] = $dbe->get_error_msg();

        } catch (InvalidDecryptionException $idce) {
            $this->dbConnection->rollback_transaction();
            $this->logger->error($idce->get_error_msg());
            $response["msg"] = $idce->get_error_msg();

        } catch (Exception $e) {
            $this->dbConnection->rollback_transaction();
            $this->logger->error($e->getMessage());
            $response["msg"] = $e->getMessage();
        }
    } 

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

    public function handle_greeting_data_extraction($requestData) {
        $requestData = json_decode($requestData);

        $encryptedFirstContact = str_replace(" ","+",rawurldecode($requestData->firstContact));
        $encryptedLinkCreator = str_replace(" ","+",rawurldecode($requestData->linkCreator));
        $timestamp = $requestData->timestamp;

        $response = [
            "decryptedFirstContact" => "",
            "decryptedLinkCreator" => "",
        ];

        try {
            $databaseOptionsController = new PslzmePublicDatabaseOptionsController($this->dbConnection);
            $customerInfo = $databaseOptionsController->select_customer_with_key();

            $encryptionKey = $customerInfo["encryptionKey"];

            $cryptoController = new PslzmePublicCryptoController();
            $decryptedFirstContact = $cryptoController->decrypt($encryptedFirstContact, $encryptionKey, $timestamp);
            $decryptedLinkCreator = $cryptoController->decrypt($encryptedLinkCreator, $encryptionKey, $timestamp);

            $response["decryptedFirstContact"] = $decryptedFirstContact;
            $response["decryptedLinkCreator"] = $decryptedLinkCreator;

        } catch (InvalidDataException $ide) {
            $this->logger->error($ide->get_error_msg());
            $response["msg"] = $ide->get_error_msg();

        } catch (DatabaseException $dbe) {
            $this->logger->error($dbe->get_error_msg());
            $response["msg"] = $dbe->get_error_msg();

        } catch (InvalidDecryptionException $idce) {
            $this->logger->error($idce->get_error_msg());
            $response["msg"] = $idce->get_error_msg();

        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            $response["msg"] = $e->getMessage();
        }

        return $response;
    }

    public function handle_compare_link_owner($requestData) {
        $requestData = json_decode($requestData);

        $combinedNameInput = $requestData->firstInput . $requestData->secondInput . $requestData->thirdInput;
        $timestamp = $requestData->timestamp;
        $encryptedLastName = str_replace(" ","+",rawurldecode($requestData->encryptedLastName));

        $response = array(
            "msg" => "",
            "nameMatchesOwner" => false,
        );

        try {
            $databaseOptionsController = new PslzmePublicDatabaseOptionsController($this->dbConnection);
            $customerInfo = $databaseOptionsController->select_customer_with_key();

            $encryptionKey = $customerInfo["encryptionKey"];
            $cryptoController = new PslzmePublicCryptoController();

            $decryptedLastName = $cryptoController->decrypt($encryptedLastName, $encryptionKey, $timestamp);

            if ($this->compare_strings($decryptedLastName, $combinedNameInput)) {
                $response["nameMatchesOwner"] = true;
            }

        } catch (InvalidDataException $ide) {
            $this->logger->error($ide->get_error_msg());
            $response["msg"] = $ide->get_error_msg();

        } catch (DatabaseException $dbe) {
            $this->logger->error($dbe->get_error_msg());
            $response["msg"] = $dbe->get_error_msg();

        } catch (InvalidDecryptionException $idce) {
            $this->logger->error($idce->get_error_msg());
            $response["msg"] = $idce->get_error_msg();

        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            $response["msg"] = $e->getMessage();
        }

        return $response;
    }


    private function compare_strings($str1, $str2) {
        $str1 = trim($str1);
        $str2 = trim($str2);

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
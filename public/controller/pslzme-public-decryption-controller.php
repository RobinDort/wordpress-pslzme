<?php

/**
 * Class that is responsible for the whole decryption process of the pslzme URL parameters and providing different functions to retreive the decrypted values. 
 * This class uses the Singleton pattern to avoid multiple instances and have a clear connection to the decrypted parameters throughout the whole plugin.
 */
class DecryptionController {
    private static ?DecryptionController $instance = null;

    private $connection;
    private $sqlExecutor;
    private $logger;

    private $encryptedLinkCreator = "";
    private $encryptedTitle = "";
    private $encryptedFirstName ="";
    private $encryptedLastName = "";
    private $encryptedGender = "";
    private $encryptedAddress = "";
    private $encryptedHousenumber = "";
    private $encryptedPostcode = "";
    private $encryptedPlace = "";
    private $encryptedCountry = "";
    private $encryptedCompanyName = "";
    private $encryptedCompanyGender = "";
    private $encryptedPosition = "";
    private $encryptedCurl = "";
    private $encryptedFC = "";
    private $timestamp = 0;


    private $decryptedLinkCreator = "";
    private $decryptedTitle = "";
    private $decryptedFirstName = "";
    private $decryptedLastName = "";
    private $decryptedCompanyName = "";
    private $decryptedCompanyGender = "";
    private $decryptedGender = "";
    private $decryptedAddress = "";
    private $decryptedHousenumber = "";
    private $decryptedPostcode = "";
    private $decryptedPlace = "";
    private $decryptedCountry = "";
    private $decryptedPosition = "";
    private $decryptedCurl = "";
    private $decryptedFC = "";


    /**
     * constructor
     * @connection Database connection created by PslzmeDatabaseConnection class located in /includes/pslzme-database-connection.php
     * @sqlExecutor Class responsible for handling public database operations located in public/controller/pslzme-public-database-options-controller.php
     * @logger Class responsible for logging info, debug, warning and error messages.
     */
    private function __construct($connection) {
        $this->connection = $connection;
        $this->sqlExecutor = new PslzmePublicDatabaseOptionsController($this->connection);

        $this->logger = PslzmeLogger::get_instance();
    }

    /**
     * This function created the singleton instance that is used throughout the plugin.
     * @return The created instance of this class.
     */
    public static function get_instance($connection = null): DecryptionController {
        if (self::$instance === null) {
            if ($connection === null) {
                $options = get_option('pslzme_settings', []);
                $dbConn = new PslzmeDatabaseConnection($options);
                $connection = $dbConn->get_connection();
            }
            self::$instance = new DecryptionController($connection);
            self::$instance->decrypt();
        }
        return self::$instance;
    }

    /**
     * This function handles the process of decrypting the pslzme URL parameters while using different database operations to retrieve needed data.
     */
    public function decrypt() {
        // Get the encrypted get parameters. Important!: => after the rawurldecode function all the "+" chars are converted to spaces " ". This is the current URL norm.
        // Because the decryption relies especially on the + char, we need to replace the spaces with the + chars again before decrypting.

        $requiredParams = ["q1", "q3", "q4", "q5", "q6", "q7", "q9", "q11"];

        if(isset($_GET["q1"])) {
            $this->encryptedLinkCreator = str_replace(" ","+",rawurldecode($_GET["q1"]));
        }

        if(isset($_GET["q2"])) {
            $this->encryptedTitle = str_replace(" ","+",rawurldecode($_GET["q2"]));
        }

        if (isset($_GET["q3"])) {
            $this->encryptedFirstName = str_replace(" ","+",rawurldecode($_GET["q3"]));
        }

        if (isset($_GET["q4"])) {
            $this->encryptedLastName = str_replace(" ","+",rawurldecode($_GET["q4"]));
        }

        if (isset($_GET["q5"])) {
            $this->encryptedCompanyName = str_replace(" ","+",rawurldecode($_GET["q5"]));
        }

        if (isset($_GET["q6"])) {
            $this->encryptedGender = str_replace(" ","+",rawurldecode($_GET["q6"]));
        }

        if (isset($_GET["q7"])) {
            $this->encryptedPosition = str_replace(" ","+",rawurldecode($_GET["q7"]));
        }

        if (isset($_GET["q8"])) {
            $this->encryptedCurl = str_replace(" ","+",rawurldecode($_GET["q8"]));
        }

        if (isset($_GET["q9"])) {
            $this->encryptedFC =str_replace(" ","+",rawurldecode($_GET["q9"]));
        }

        if (isset($_GET["q10"])) {
            $this->timestamp = $_GET["q10"];
        }

        if (isset($_GET["q11"])) {
            $this->encryptedCompanyGender = str_replace(" ","+",rawurldecode($_GET["q11"]));
        }

        if (isset($_GET["q12"])) {
            $this->encryptedAddress = str_replace(" ","+",rawurldecode($_GET["q12"]));
        }

        if (isset($_GET["q13"])) {
            $this->encryptedHousenumber = str_replace(" ","+",rawurldecode($_GET["q13"]));
        }

        if (isset($_GET["q14"])) {
            $this->encryptedPostcode = str_replace(" ","+",rawurldecode($_GET["q14"]));
        }

        if (isset($_GET["q15"])) {
            $this->encryptedPlace = str_replace(" ","+",rawurldecode($_GET["q15"]));
        }

        if (isset($_GET["q16"])) {
            $this->encryptedCountry = str_replace(" ","+",rawurldecode($_GET["q16"]));
        }

        $requiredParamsSet = $this->check_for_required_params($requiredParams);

        if ($requiredParamsSet) {
            try {
                // Get the customer with its ID and its encrypt ID.
                $customerInfo = $this->sqlExecutor->select_customer_with_key();

                $customerID = $customerInfo["customerID"];
                $encryptionID = $customerInfo["encryptionID"];
                $encryptionKey = $customerInfo["encryptionKey"];

                //check if the customer has given permission to decrypt his data.
                $cookieQueryData = array(
                    "customerID" => $customerID,
                    "encryptID" => $encryptionID,
                    "timestamp" => $this->timestamp
                );

                $selectCookieResp = $this->sqlExecutor->select_query_acceptance($cookieQueryData);
                $cookieAccepted = $selectCookieResp["cookieAccepted"];

                $cookie = isset($_COOKIE["consent_cookie"]) ? $_COOKIE["consent_cookie"] : null;
                if ($cookie === null) {
                    throw new InvalidDataException("No consent cookie found!");
                }
                
                $cookieData = json_decode(stripslashes($cookie), true);

                //only decrypt when the user has given permission and the cookie is set
                if ((bool)$cookieAccepted === true && (bool)$cookieData["accepted"] === true) {
                    //decrypt the params

                    $this->decryptedLinkCreator = PslzmePublicCryptoService::decrypt($this->encryptedLinkCreator, $encryptionKey, $this->timestamp);
                    $this->decryptedTitle = PslzmePublicCryptoService::decrypt($this->encryptedTitle, $encryptionKey, $this->timestamp);
                    $this->decryptedFirstName = PslzmePublicCryptoService::decrypt($this->encryptedFirstName, $encryptionKey, $this->timestamp);
                    $this->decryptedLastName = PslzmePublicCryptoService::decrypt($this->encryptedLastName, $encryptionKey, $this->timestamp);
                    $this->decryptedCompanyName = PslzmePublicCryptoService::decrypt($this->encryptedCompanyName, $encryptionKey, $this->timestamp);
                    $this->decryptedCompanyGender = PslzmePublicCryptoService::decrypt($this->encryptedCompanyGender, $encryptionKey, $this->timestamp);
                    $this->decryptedGender = PslzmePublicCryptoService::decrypt($this->encryptedGender, $encryptionKey, $this->timestamp);
                    $this->decryptedPosition = PslzmePublicCryptoService::decrypt($this->encryptedPosition, $encryptionKey, $this->timestamp);
                    $this->decryptedCurl = PslzmePublicCryptoService::decrypt($this->encryptedCurl, $encryptionKey, $this->timestamp);
                    $this->decryptedFC = PslzmePublicCryptoService::decrypt($this->encryptedFC, $encryptionKey, $this->timestamp);
                    $this->decryptedAddress = PslzmePublicCryptoService::decrypt($this->encryptedAddress, $encryptionKey, $this->timestamp);
                    $this->decryptedHousenumber = PslzmePublicCryptoService::decrypt($this->encryptedHousenumber, $encryptionKey, $this->timestamp);
                    $this->decryptedPostcode = PslzmePublicCryptoService::decrypt($this->encryptedPostcode, $encryptionKey, $this->timestamp);
                    $this->decryptedPlace = PslzmePublicCryptoService::decrypt($this->encryptedPlace, $encryptionKey, $this->timestamp);
                    $this->decryptedCountry = PslzmePublicCryptoService::decrypt($this->encryptedCountry, $encryptionKey, $this->timestamp);  
                    
                }

            } catch (InvalidDataException $ide) {
                $this->logger->error($ide->get_error_msg());

            } catch (DatabaseException $dbe) {
                $this->logger->error($dbe->get_error_msg());

            } catch (InvalidDecryptionException $idce) {
                $this->logger->error($idce->get_error_msg());

            } catch (Exception $e) {
                $this->logger->error($e->getMessage());
            }
        }
    }

    /**
     * This functions checks if all the required and non optional parameters are set inside the URL.
     * @requiredParams Array containing the required parameters.
     * @return true when "q1", "q3", "q4", "q5", "q6", "q7", "q9", "q11" are set, false otherwise.
     */
    private function check_for_required_params($requiredParams) {
        foreach($requiredParams as $key) {
            if(!isset($_GET[$key])) {
                return false;
            }
        }
        return true;
    }

    /**
     * This function is used to check if the URL parameters are successfully decrypted and currently available.
     * @return true when the parameters have been decrypted and are available, false otherwise.
     */
    public function vars_set() {
        if ($this->get_decrypted_link_creator() !== "" && $this->get_decrypted_first_name() !== "" && $this->get_decrypted_last_name() !== "") {
            return true;
        } else {
            return false;
        }
    }

    public function get_decrypted_link_creator() {
        return $this->decryptedLinkCreator;
    }

    public function get_decrypted_title() {
        return $this->decryptedTitle;
    }

    public function get_decrypted_first_name() {
        return $this->decryptedFirstName;
    }

    public function get_decrypted_last_name() {
        return $this->decryptedLastName;
    }

    public function get_decrypted_company_name() {
        return $this->decryptedCompanyName;
    }

    public function get_decrypted_company_gender() {
        return $this->decryptedCompanyGender;
    }

    public function get_decrypted_gender() {
        return $this->decryptedGender;
    }

    public function get_decrypted_address() {
        return $this->decryptedAddress;
    }

    public function get_decrypted_housenumber() {
        return $this->decryptedHousenumber;
    }

    public function get_decrypted_postcode() {
        return $this->decryptedPostcode;
    }

    public function get_decrypted_place() {
        return $this->decryptedPlace;
    }

    public function get_decrypted_country() {
        return $this->decryptedCountry;
    }

    public function get_decrypted_position() {
        return $this->decryptedPosition;
    }

    public function get_decrypted_curl() {
        return $this->decryptedCurl;
    }

    public function get_decrypted_fc() {
        return $this->decryptedFC;
    }
}

?>
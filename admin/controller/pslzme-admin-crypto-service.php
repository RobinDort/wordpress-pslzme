<?php

final class PslzmeAdminCryptoService {

    private const OPTION_KEY = "pslzme_crypto_key";
    private const CIPHER = "aes-256-cbc";
    

    private function __construct() {}


    // Generates a deterministic key based on WordPress secret keys
    private static function get_key() {

        $pluginKey = get_option(self::OPTION_KEY);

        if (!$pluginKey) {
            $pluginKey = base64_encode(random_bytes(32));
            update_option(self::OPTION_KEY, $pluginKey);
        }

       $wpSalt = defined("LOGGED_IN_KEY") ? LOGGED_IN_KEY : '';

       return hash("sha256", base64_decode($pluginKey) . $wpSalt, true);

    } 

    // Encrypt plaintext
    public static function encrypt(string $plaintext) {
        if ( ! extension_loaded( 'openssl' ) ) {
            return false;
        }

        $ivLength = openssl_cipher_iv_length(self::CIPHER);
        $iv       = random_bytes($ivLength);
        $key      = self::get_key();

        $ciphertext = openssl_encrypt(
            $plaintext,
            self::CIPHER,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

        if ($ciphertext === false) {
            return false;
        }

        return base64_encode($iv . $ciphertext);
    }

    // Decrypt previously encrypted text
    public static function decrypt(string $encryptedData): string {
        if ( ! extension_loaded( 'openssl' ) ) {
		    return false;
	    }

        $data = base64_decode($encryptedData, true);
        if ($data === false) {
            return false;
        }

        $ivLength = openssl_cipher_iv_length(self::CIPHER);
        if (strlen($data) <= $ivLength) {
            return false;
        }

        $iv         = substr($data, 0, $ivLength);
        $ciphertext = substr($data, $ivLength);
        $key        = self::get_key();

        return openssl_decrypt(
            $ciphertext,
            self::CIPHER,
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );

    }
}

?>
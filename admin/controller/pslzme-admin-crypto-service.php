<?php

/**
 * Class that encryption and decryption functionality for admin side operations.
 * Final class and private constructor to act as utility class and prevent inheritance and initialization.
 */
final class PslzmeAdminCryptoService {

    private const OPTION_KEY = "pslzme_crypto_key";
    private const CIPHER = "AES-128-CTR";
    

    private function __construct() {}


    /**
     * 
     * This function generates a deterministic key based on WordPress secret keys
     * @return The generated key for encryption and decryption.
     * 
     */
    private static function get_key() {

       $keyInfo = get_option(self::OPTION_KEY);

       if (!$keyInfo) {
            $keyBin = random_bytes(16);
            $key = bin2hex($keyBin);
            $timestamp = time();
            $keyInfo = [
                'key'       => $key,
                'timestamp' => $timestamp
            ];
            update_option(self::OPTION_KEY, $keyInfo);
       }

       return $keyInfo;
    } 

    /**
     * 
     * This function encrypts a plaintext by using the generated key.
     * @var plaintext The text/value that will be encrypted.
     * @return The encrypted plaintext.
     * 
     */
    public static function encrypt(string $plaintext): ?string {
        if ( ! extension_loaded( 'openssl' ) ) {
            return null;
        }

        $keyInfo      = self::get_key();
        $key = $keyInfo['key'];
        $timestamp = $keyInfo['timestamp'];

        if (!$key || !$timestamp) {
            error_log('Crypto key invalid');
            return null;
        }

        // $ivLength = openssl_cipher_iv_length(self::CIPHER);
        // $iv       = random_bytes($ivLength);
        $keyBin = hex2bin($key);
        $iv = substr(hash('sha256', $timestamp, true), 0, 16);

        $ciphertext = openssl_encrypt(
            $plaintext,
            self::CIPHER,
            $keyBin,
            0,
            $iv
        );

        if ($ciphertext === false) {
            return null;
        }
        
        return $ciphertext;
    }

    /**
     * 
     * This function decrypts a previously encrypted text/value again by using the same key.
     * @var encryptedData The already encrypted data.
     * @return The decrypted plaintext/data.
     * 
     */
    public static function decrypt(string $encryptedData): ?string {
        if ( ! extension_loaded( 'openssl' ) ) {
		    return null;
        }

        $keyInfo        = self::get_key();
        $key = $keyInfo['key'];
        $timestamp = $keyInfo['timestamp'];

        if (!$key || !$timestamp) {
            error_log('Crypto key invalid');
            return null;
        }
        $keyBin = hex2bin($key);
        $iv = substr(hash('sha256', $timestamp, true), 0, 16);
        // $iv         = substr($data, 0, $ivLength);
        // $ciphertext = substr($data, $ivLength);


        $plaintext = openssl_decrypt(
            $encryptedData,
            self::CIPHER,
            $keyBin,
            0,
            $iv
        );

        return ($plaintext === false) ? null : $plaintext;

    }
}

?>
<?php
/**
 * Class that handles the decryption of the pslzme link parameters.
 */
final class PslzmePublicCryptoService {
    private static $ciphering = "AES-128-CTR";

    private function __construct() {}

    /**
     * This function decrypts the encrypted link parameters of pslzme.
     * @encryptedValue One of the pslzme paramters located inside the URL.
     * @encryptionKey A passed key that is used to decrypt the params.
     * @timestamp A timestamp that is located inside the URL params.
     * @return A decrypted value.
     * @throws InvalidDecryptionException when the value cannot be decrypted.
     */
    public static function decrypt($encryptedValue, $encryptionKey, $timestamp) {
        $iv_length = openssl_cipher_iv_length(self::$ciphering);
        $options = 0;
        $decryption_iv = substr(hash('sha256', $timestamp, true), 0, 16);
        $decryptionKeyBin = hex2bin($encryptionKey);

        $decryptedValue = openssl_decrypt($encryptedValue, self::$ciphering, 
                        $decryptionKeyBin, $options, $decryption_iv);

        if ($decryptedValue === false || !mb_check_encoding($decryptedValue, 'UTF-8')) {
                throw new InvalidDecryptionException("Unable to decrypt value: " . $encryptedValue);
        }

        return $decryptedValue;
    }

}

?>
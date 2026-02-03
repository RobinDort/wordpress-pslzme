<?php

final class PslzmePublicCryptoService {
    private static $ciphering = "AES-128-CTR";

    private function __construct() {}

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
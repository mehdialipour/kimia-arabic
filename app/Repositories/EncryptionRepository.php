<?php


namespace App\Repositories;

use Illuminate\Support\Facades\Cache;
use phpseclib\Crypt\RSA;

class EncryptionRepository
{
    private $publicKey;
    private $privateKey;

    public function __construct()
    {
        $this->getKeys();
    }

    /**
     * get RSA public key
     *
     * @return string
     */
    public static function getPublicKey(): string
    {
        return $this->publicKey;
    }

    /**
     * decrypt ciphered input
     *
     * @param string $value
     * @return string
     */
    public static function decrypt(string $value): string
    {
        $rsa = new RSA();
        $rsa->setEncryptionMode(RSA::ENCRYPTION_PKCS1);
        $rsa->loadKey($this->getPrivateKey());
        return $rsa->decrypt($value);
    }

    /**
     * encrypt input value
     *
     * @param string $value
     * @return string
     */
    public static function encrypt(string $value, string $public_key): string
    {
        $rsa = new RSA();
        $rsa->setEncryptionMode(RSA::ENCRYPTION_PKCS1);
        $rsa->loadKey($public_key);
        return $rsa->encrypt($value);
    }

    /**
     * generate new pair of keys
     *
     * @return array
     */
    private function generateKeys() : array
    {
        $rsa = new RSA();
        return $rsa->createKey();
    }

    /**
     * get public and private keys
     *
     * @return array
     */
    private function getKeys() : array
    {
        if (!Cache::has('rsaKeys')) {
            Cache::put('rsaKeys', $this->generateKeys(), 7*24*60*60);
        }

        $keys = Cache::get('rsaKeys');
        $this->publicKey = $keys['publickey'];
        $this->privateKey = $keys['privatekey'];
        return $keys;
    }

    /**
     * get private key
     *
     * @return string
     */
    public static function getPrivateKey(): string
    {
        return $this->privateKey;
    }
}

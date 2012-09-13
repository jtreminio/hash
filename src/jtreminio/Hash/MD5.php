<?php

namespace jtreminio\Hash;

class MD5 extends Hash
{

    const ALGO_NAME = 'CRYPT_MD5';
    const COST_MIN = 1;
    const COST_MAX = 2;
    const COST_DEFAULT = 1;
    const PREFIX = '$1$';
    const SALT_LENGTH = 8;

    /**
     * Hashes password using selected algo
     *
     * @param string $password Unmodified password
     * @return string
     */
    public function hash($password)
    {
        $salt = self::PREFIX.$this->generateSalt();

        return $this->validateHash(crypt($password, $salt));
    }

}
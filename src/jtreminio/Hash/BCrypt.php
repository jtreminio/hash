<?php

namespace jtreminio\Hash;

class BCrypt extends Hash
{

    const ALGO_NAME = 'CRYPT_BLOWFISH';
    const COST_MIN = 4;
    const COST_MAX = 31;
    const COST_DEFAULT = 12;
    const PREFIX = '$2y$';
    const SALT_LENGTH = 22;

}
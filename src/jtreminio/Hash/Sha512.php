<?php

namespace jtreminio\Hash;

class Sha512 extends Hash
{
    const COST_MIN = 1000;
    const COST_MAX = 999999999;
    const COST_DEFAULT = 10000;
    const PREFIX = '$6$rounds=';
    const SALT_LENGTH = 16;

}
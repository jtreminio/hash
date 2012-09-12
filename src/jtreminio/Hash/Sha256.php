<?php

namespace jtreminio\Hash;

class Sha256 extends Hash
{
    const COST_MIN = 1000;
    const COST_MAX = 999999999;
    const COST_DEFAULT = 10000;
    const PREFIX = '$5$rounds=';
    const SALT_LENGTH = 16;

}
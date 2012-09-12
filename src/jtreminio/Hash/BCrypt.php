<?php

namespace jtreminio\Hash;

class BCrypt extends Hash
{
    const COST_MIN = 4;
    const COST_MAX = 31;
    const COST_DEFAULT = 12;
    const PREFIX = '$2a$';
    const SALT_LENGTH = 22;

}
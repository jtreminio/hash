<?php

namespace jtreminio\Hash;

class Exception extends \Exception
{

    /**
     * Only set here to make sure we get coverage.
     * Only calls parent constructor.
     *
     * @param string $message Message
     * @param int    $code Code
     */
    public function __construct($message = null, $code = 0)
    {
        parent::__construct($message, $code);
    }

}
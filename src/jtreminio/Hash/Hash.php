<?php

namespace jtreminio\Hash;

/**
 * Hash is base class for password hashing using crypt()
 *
 * @author Juan Treminio <jtreminio@gmail.com>
 */
abstract class Hash
{
    protected $rounds;

    const SALT_LENGTH = 10;

    public function __construct($rounds = false)
    {
        if (!$rounds) {
            $class = get_called_class();

            $rounds = $class::COST_DEFAULT;
        }

        $this->setRounds($rounds);
    }

    /**
     * Hashes password using bcrypt
     *
     * @param string $password Unmodified password
     * @return string
     */
    public function hash($password)
    {
        $class = get_called_class();

        $salt = $class::PREFIX.$this->rounds.'$'.$this->generateSalt();

        return crypt($password, $salt);
    }

    /**
     * Generates salt for use in hashing password
     *
     * @return string
     */
    protected function generateSalt()
    {
        $class = get_called_class();

        return substr(hash('sha256', uniqid('', true)), 0, $class::SALT_LENGTH);
    }

    /**
     * Checks that password provided matches original password
     *
     * @param string $password Unmodified password
     * @param string $hash     Hashed password
     *
     * @return bool
     */
    public function check($password, $hash)
    {
        if (crypt($password, $hash) == $hash) {
            return true;
        }

        return false;
    }

    /**
     * Set number of rounds for hashing
     *
     * @param int $rounds Work factor crypt should do
     * @return self
     */
    public function setRounds($rounds)
    {
        $class = get_called_class();

        if ($rounds < $class::COST_MIN) {
            $rounds = $class::COST_MIN;
        } elseif ($rounds > $class::COST_MAX) {
            $rounds = $class::COST_MAX;
        }

        $this->rounds = $rounds;

        return $this;
    }

    /**
     * Return rounds for hash
     *
     * @return mixed
     */
    public function getRounds()
    {
        return $this->rounds;
    }

}
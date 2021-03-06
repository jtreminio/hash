<?php

namespace jtreminio\Hash;

/**
 * Hash is base class for password hashing using crypt()
 *
 * @author Juan Treminio <jtreminio@gmail.com>
 */
abstract class Hash
{

    /** @var int */
    protected $rounds;

    const ALGO_NAME   = 0;
    const SALT_LENGTH = 10;

    public function __construct($rounds = false)
    {
        $this->algoEnabled();
        $this->setRounds($rounds);
    }

    /**
     * Hashes password using selected algo
     *
     * @param string $password Unmodified password
     * @return string
     */
    public function hash($password)
    {
        $class = get_called_class();

        $salt = $class::PREFIX.$this->rounds.'$'.$this->generateSalt().'$';

        return $this->validateHash(crypt($password, $salt));
    }

    /**
     * Validated a hash generated by crypt()
     *
     * @param string $hash Hashed password
     *
     * @return string
     * @throws Exception
     */
    protected function validateHash($hash)
    {
        // On failure, crypt() will either return '*0', '*1' or a DES hash 13 characters in length
        if ($hash === '*0' || $hash === '*1' || strlen($hash) <= 13) {
            throw new Exception("Password hash appears to be invalid: {$hash}");
        }

        return $hash;
    }

    /**
     * Checks that current algorithm is enabled on system
     *
     * @return null
     * @throws Exception
     */
    protected function algoEnabled()
    {
        $algoName = $this->getAlgoName();

        if (!defined($algoName) || constant($algoName) !== 1) {
            throw new Exception("Algorithm '{$algoName}' is not enabled on this system.");
        }
    }

    /**
     * Returns string name of algorithm currently being used
     *
     * @return string
     */
    protected function getAlgoName()
    {
        $class = get_called_class();

        return $class::ALGO_NAME;
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
        if (crypt($password, $hash) === $hash) {
            return true;
        }

        return false;
    }

    /**
     * Set number of rounds for hashing
     *
     * @param int $rounds Work factor crypt should do
     *
     * @return null
     */
    public function setRounds($rounds)
    {
        $class = get_called_class();

        if (!$rounds) {
            $rounds = $class::COST_DEFAULT;
        } elseif ($rounds < $class::COST_MIN) {
            $rounds = $class::COST_MIN;
        } elseif ($rounds > $class::COST_MAX) {
            $rounds = $class::COST_MAX;
        }

        $this->rounds = $rounds;
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
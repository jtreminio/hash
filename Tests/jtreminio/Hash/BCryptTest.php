<?php

namespace jtreminio\Hash;

class BCryptTest extends \jtreminio\Test\Base
{

    /**
     * @test
     */
    public function hashUsesCorrectAlgo()
    {
        $hasher = new BCrypt();

        $hash = $hasher->hash('foo');

        $expectedAlgoPosition = 0;
        $expectedAlgoIdentifier = BCrypt::PREFIX;
        $actualAlgoPosition = strpos($hash, $expectedAlgoIdentifier);

        $this->assertSame(
            $expectedAlgoPosition,
            $actualAlgoPosition,
            "Password is not using bcrypt hashing, expected '{$expectedAlgoIdentifier}' identifier"
        );
    }

    /**
     * @test
     */
    public function hashIsCorrectLength()
    {
        $hasher = new BCrypt();

        $hash = $hasher->hash('foo');

        $expectedHashLength = 60;
        $hashLength = strlen($hash);

        $this->assertEquals(
            $expectedHashLength,
            $hashLength,
            "bcrypt hash expected to be {$expectedHashLength} characters in length"
        );
    }

    /**
     * @test
     */
    public function generateSaltIsCorrectLength()
    {
        $hasher = new BCrypt();

        $salt = $this->invokeMethod(
            $hasher,
            'generateSalt'
        );

        $saltLength = strlen($salt);

        $expectedSaltLength = BCrypt::SALT_LENGTH;

        $this->assertEquals(
            $expectedSaltLength,
            $saltLength,
            "Expected salt length to be {$expectedSaltLength}"
        );
    }

}
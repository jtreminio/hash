<?php

namespace jtreminio\Hash;
use \jtreminio\TestExtensions\TestExtensions;

class BCryptTest extends TestExtensions
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
        $actualHashLength = strlen($hash);

        $this->assertEquals(
            $expectedHashLength,
            $actualHashLength,
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
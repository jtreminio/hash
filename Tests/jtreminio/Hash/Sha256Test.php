<?php

namespace jtreminio\Hash;
use \jtreminio\TestExtensions\TestExtensions;

class Sha256Test extends TestExtensions
{

    /**
     * @test
     */
    public function hashUsesCorrectAlgo()
    {
        $hasher = new Sha256();

        $hash = $hasher->hash('foo');

        $expectedAlgoPosition = 0;
        $expectedAlgoIdentifier = Sha256::PREFIX;
        $actualAlgoPosition = strpos($hash, $expectedAlgoIdentifier);

        $this->assertSame(
            $expectedAlgoPosition,
            $actualAlgoPosition,
            "Password is not using Sha256 hashing, expected '{$expectedAlgoIdentifier}' identifier"
        );
    }

    /**
     * @test
     */
    public function hashIsCorrectLength()
    {
        $hasher = new Sha256();

        $hash = $hasher->hash('foo');

        $expectedHashLength = 76;
        $actualHashLength = strlen($hash);

        $this->assertEquals(
            $expectedHashLength,
            $actualHashLength,
            "Sha256 hash expected to be {$expectedHashLength} characters in length"
        );
    }

    /**
     * @test
     */
    public function generateSaltIsCorrectLength()
    {
        $hasher = new Sha256();

        $salt = $this->invokeMethod(
            $hasher,
            'generateSalt'
        );

        $saltLength = strlen($salt);

        $expectedSaltLength = Sha256::SALT_LENGTH;

        $this->assertEquals(
            $expectedSaltLength,
            $saltLength,
            "Expected salt length to be {$expectedSaltLength}"
        );
    }

}
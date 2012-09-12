<?php

namespace jtreminio\Hash;
use \jtreminio\Test\TestExtensions;

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

        $minimumHashLength = 76;
        $maximumHashLength = 119;
        $hashLength = strlen($hash);

        $this->assertGreaterThanOrEqual(
            $minimumHashLength,
            $hashLength,
            "Sha256 hash expected to be greater than {$minimumHashLength} characters in length"
        );

        $this->assertLessThanOrEqual(
            $maximumHashLength,
            $hashLength,
            "Sha256 hash expected to be less than or equal to {$maximumHashLength} characters in length"
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
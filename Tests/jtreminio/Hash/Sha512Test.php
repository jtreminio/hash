<?php

namespace jtreminio\Hash;
use \jtreminio\TestExtensions\TestExtensions;

class Sha512Test extends TestExtensions
{

    /**
     * @test
     */
    public function hashUsesCorrectAlgo()
    {
        $hasher = new Sha512();

        $hash = $hasher->hash('foo');

        $expectedAlgoPosition = 0;
        $expectedAlgoIdentifier = Sha512::PREFIX;
        $actualAlgoPosition = strpos($hash, $expectedAlgoIdentifier);

        $this->assertSame(
            $expectedAlgoPosition,
            $actualAlgoPosition,
            "Password is not using sha512 hashing, expected '{$expectedAlgoIdentifier}' identifier"
        );
    }

    /**
     * @test
     */
    public function hashIsCorrectLength()
    {
        $hasher = new Sha512();

        $hash = $hasher->hash('foo');

        $expectedHashLength = 119;
        $actualHashLength = strlen($hash);

        $this->assertEquals(
            $expectedHashLength,
            $actualHashLength,
            "sha512 hash expected to be {$expectedHashLength} characters in length"
        );
    }

    /**
     * @test
     */
    public function generateSaltIsCorrectLength()
    {
        $hasher = new Sha512();

        $salt = $this->invokeMethod(
            $hasher,
            'generateSalt'
        );

        $saltLength = strlen($salt);

        $expectedSaltLength = Sha512::SALT_LENGTH;

        $this->assertEquals(
            $expectedSaltLength,
            $saltLength,
            "Expected salt length to be {$expectedSaltLength}"
        );
    }

}
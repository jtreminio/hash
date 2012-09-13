<?php

namespace jtreminio\Hash;
use \jtreminio\TestExtensions\TestExtensions;

class StdDesTest extends TestExtensions
{

    /**
     * @test
     */
    public function hashIsCorrectLength()
    {
        $hasher = new StdDes();

        $hash = $hasher->hash('foo');

        $expectedHashLength = 13;
        $actualHashLength = strlen($hash);

        $this->assertEquals(
            $expectedHashLength,
            $actualHashLength,
            "StdDes hash expected to be {$expectedHashLength} characters in length"
        );
    }

    /**
     * @test
     */
    public function generateSaltIsCorrectLength()
    {
        $hasher = new StdDes();

        $salt = $this->invokeMethod(
            $hasher,
            'generateSalt'
        );

        $saltLength = strlen($salt);

        $expectedSaltLength = StdDes::SALT_LENGTH;

        $this->assertEquals(
            $expectedSaltLength,
            $saltLength,
            "Expected salt length to be {$expectedSaltLength}"
        );
    }

}
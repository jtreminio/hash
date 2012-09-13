<?php

namespace jtreminio\Hash;
use \jtreminio\TestExtensions\TestExtensions;

class HashTest extends TestExtensions
{

    /**
     * @test
     * @dataProvider providerSetRoundsSetsCorrectRoundValue
     */
    public function setRoundsSetsCorrectRoundValue(
        $requestedRounds,
        $expectedRounds
    )
    {
        $hasher = new Sha512($requestedRounds);

        $actualRounds = $hasher->getRounds();

        $this->assertEquals(
            $expectedRounds,
            $actualRounds,
            'Expected rounds does not equal actual rounds'
        );
    }

    /**
     * Provider for setRoundsSetsCorrectRoundValue
     *
     * @return array
     */
    public function providerSetRoundsSetsCorrectRoundValue()
    {
        /**
         * Passed Value
         * Return Value
         */
        return array(
            array(-10,        1000),
            array(0,          10000),
            array(10,         1000),
            array(999,        1000),
            array(1000,       1000),
            array(5000,       5000),
            array(10000,      10000),
            array(999999999,  999999999),
            array(1000000000, 999999999),
        );
    }

    /**
     * @test
     */
    public function generateSaltCreatesUniqueString()
    {
        $hasher = $this->getMockBuilder('jtreminio\Hash\Hash')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $salt1 = $this->invokeMethod(
            $hasher,
            'generateSalt'
        );

        $salt2 = $this->invokeMethod(
            $hasher,
            'generateSalt'
        );

        $this->assertNotEquals(
            $salt1,
            $salt2,
            'Generated salts are not unique'
        );
    }

    /**
     * @test
     */
    public function checkReturnsTrueOnSamePasswords()
    {
        $hasher = new BCrypt();

        $password = 'thisismyawesome1234556password';

        $passwordHash = $hasher->hash($password);

        $this->assertTrue(
            $hasher->check(
                $password,
                $passwordHash
            )
        );
    }

    /**
     * @test
     */
    public function checkReturnsFalseOnIncorrectPassword()
    {
        $hasher = new Sha512();

        $password = 'thisismyawesome1234556password';
        $incorrectPassword = 'blahblah123';

        $passwordHash = $hasher->hash($password);

        $this->assertFalse(
            $hasher->check(
                $incorrectPassword,
                $passwordHash
            )
        );
    }

    /**
     * @test
     */
    public function algoEnabledThrowsExceptionOnAlgoNotDefined()
    {
        $undefinedConstant = 'UNDEFINED_CONSTANT_123';

        $this->setExpectedException(
            'jtreminio\Hash\Exception',
            "Algorithm '{$undefinedConstant}' is not enabled on this system."
        );

        $hasher = $this->getMockBuilder('jtreminio\Hash\Hash')
            ->disableOriginalConstructor()
            ->setMethods(array('getAlgoName'))
            ->getMockForAbstractClass();

        $hasher->expects($this->once())
            ->method('getAlgoName')
            ->will($this->returnValue($undefinedConstant));

        $this->invokeMethod(
            $hasher,
            'algoEnabled'
        );
    }

    /**
     * @test
     */
    public function algoEnabledThrowsExceptionOnAlgoConstantValueNotOne()
    {
        $constantWithValueNotOne = 'E_WARNING';

        $this->setExpectedException(
            'jtreminio\Hash\Exception',
            "Algorithm '{$constantWithValueNotOne}' is not enabled on this system."
        );

        $hasher = $this->getMockBuilder('jtreminio\Hash\Hash')
            ->disableOriginalConstructor()
            ->setMethods(array('getAlgoName'))
            ->getMockForAbstractClass();

        $hasher->expects($this->once())
            ->method('getAlgoName')
            ->will($this->returnValue($constantWithValueNotOne));

        $this->invokeMethod(
            $hasher,
            'algoEnabled'
        );
    }
}
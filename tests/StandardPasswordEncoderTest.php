<?php

namespace Darkindy\SpringPasswordUtils;

use PHPUnit\Framework\TestCase;

/**
 * Tests for StandardPasswordEncoder utility
 *
 * @author Andrei Pietrușel
 */
class StandardPasswordEncoderTest extends TestCase
{
    private const ENCODED_PASSWORD = "1ee070812605db4ab1950813a042717eb3f0bdf8395bac71d3eb9b8eeefcd5e86626731b2d41c864";
    private const RAW_PASSWORD = "1234";

    private const PASSWORD_TO_ENCODE = "Darkindyß";
    private const SALT_TO_ENCODE = "1BaHku&7";
    private const EXPECTED_ENCODED_PASSWORD = "314261486b752637c6b53e6df54f937d229224965d58548a53beba5c4fc001083a5786aaac9cd448";

    public function testIsThereAnySyntaxError()
    {
        $var = new StandardPasswordEncoder;
        $this->assertTrue(is_object($var));
        unset($var);
    }

    public function testMatches()
    {
        $var = new StandardPasswordEncoder;
        $this->assertTrue($var->matches(self::RAW_PASSWORD, self::ENCODED_PASSWORD) === true);
        unset($var);
    }

    public function testEncode()
    {
        $var = new StandardPasswordEncoder;
        $this->assertTrue($var->encode(self::PASSWORD_TO_ENCODE, self::SALT_TO_ENCODE) === self::EXPECTED_ENCODED_PASSWORD);
        unset($var);
    }

    public function testEncodeThenMatches()
    {
        $var = new StandardPasswordEncoder;
        $encodedPassword = $var->encode(self::PASSWORD_TO_ENCODE, self::SALT_TO_ENCODE);
        $this->assertTrue($var->matches(self::PASSWORD_TO_ENCODE, $encodedPassword) === true);
        unset($var);
    }

    public function testEncodeThenMatchesAutoSalt()
    {
        $var = new StandardPasswordEncoder;
        $encodedPassword = $var->encode(self::PASSWORD_TO_ENCODE);
        $this->assertTrue($var->matches(self::PASSWORD_TO_ENCODE, $encodedPassword) === true);
        unset($var);
    }

}

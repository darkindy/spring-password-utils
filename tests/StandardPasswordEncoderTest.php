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
    const ENCODED_PASSWORD = "1ee070812605db4ab1950813a042717eb3f0bdf8395bac71d3eb9b8eeefcd5e86626731b2d41c864";
    const RAW_PASSWORD = "1234";

    const PASSWORD_TO_ENCODE = "Darkindyß";
    const EXPECTED_ENCODED_PASSWORD = "a840d8c14f8695b51fe596a8ed6e156934460f2637efcc86f6930905deec2578929b6dad2f5ca021";
    const EXPECTED_ENCODED_PASSWORD2 = "4fd886b595a840c1a840d8c14f8695b5d7405efe604c9cbab3dda679752a8c36d0da8d3d3d6c15bf9843fde10f8faf9b";

    private static function SALT_TO_ENCODE()
    {
        return call_user_func_array("pack", array_merge(
            array("C*"), array(-88, 64, -40, -63, 79, -122, -107, -75)));
    }

    private static function SALT_TO_ENCODE16()
    {
        return call_user_func_array("pack", array_merge(
            array("C*"), array(79, -40, -122, -75, -107, -88, 64, -63, -88, 64, -40, -63, 79, -122, -107, -75)));
    }

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
        $this->assertTrue($var->encode(self::PASSWORD_TO_ENCODE, self::SALT_TO_ENCODE()) === self::EXPECTED_ENCODED_PASSWORD);
        unset($var);
    }

    public function testEncodeThenMatches()
    {
        $var = new StandardPasswordEncoder;
        $encodedPassword = $var->encode(self::PASSWORD_TO_ENCODE, self::SALT_TO_ENCODE());
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

    public function testEncode16BytesSalt()
    {
        $var = new StandardPasswordEncoder;
        $this->assertTrue($var->encode(self::PASSWORD_TO_ENCODE, self::SALT_TO_ENCODE16()) === self::EXPECTED_ENCODED_PASSWORD2);
        unset($var);
    }

    public function testEncodeThenMatches16BytesSalt()
    {
        $var = new StandardPasswordEncoder;
        $encodedPassword = $var->encode(self::PASSWORD_TO_ENCODE, self::SALT_TO_ENCODE16());
        $this->assertTrue($var->matches(self::PASSWORD_TO_ENCODE, $encodedPassword, 16) === true);
        unset($var);
    }

}

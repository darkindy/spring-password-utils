<?php

namespace Darkindy\SpringPasswordUtils;

/**
 * Mimics the behaviour of Spring Security's Java class of the same name.
 *
 * @author Andrei Pietrușel
 */
class StandardPasswordEncoder
{

    private const HASH_ALGORITHM = 'SHA256';
    private const HASH_ITERATIONS = 1024;
    private const HASH_LENGTH = 80;

    /**
     * Checks if the given password matches a previously computed encoded password, thus validating authentication.
     * The encoded password is usually taken from the password column in the database.
     *
     * @param string $rawPassword The password to validate.
     * @param string $encodedPassword The encoded password hash, which includes salt prefix.
     * @param int $saltPrefixLength The length of the salt prefix of the encoded password. Defaults to 8.
     *
     * @return boolean
     */
    public function matches($rawPassword, $encodedPassword, $saltPrefixLength = 8)
    {
        $decodedDigest = hex2bin($encodedPassword);
        $salt = substr($decodedDigest, 0, $saltPrefixLength);
        $computedDigest = $this->digest($rawPassword, $salt);
        return $decodedDigest === $computedDigest;
    }

    /**
     * Encodes a password in the same way as Spring Security's StandardPasswordEncoder with default settings.
     *
     * @param $rawPassword The password to encode.
     * @param $salt Optional salt used for encoding the password.
     *              For test-proven results use a random length 8 ASCII string. If not specified it will be auto-provided.
     * @return string The encoded password, ready to be stored in the database.
     */
    public function encode($rawPassword, $salt = null)
    {
        if (is_null($salt)) {
            $salt = bin2hex(openssl_random_pseudo_bytes(4));
        }
        $computedDigest = $this->digest($rawPassword, $salt);
        return bin2hex($computedDigest);
    }

    private function digest($rawPassword, $salt)
    {
        $utf8RawPassword = mb_convert_encoding($rawPassword, "UTF-8");
        $digest = $this->hash($utf8RawPassword, $salt);
        return $salt . $digest;
    }

    private function hash($password, $salt)
    {
        $password = $salt . $password;
        for ($j = 0; $j < self::HASH_ITERATIONS; $j++) {
            $password = hash(self::HASH_ALGORITHM, $password, true);
        }
        return $password ? substr($password, 0, self::HASH_LENGTH) : $password;
    }

}


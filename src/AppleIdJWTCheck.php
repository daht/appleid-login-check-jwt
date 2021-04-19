<?php

namespace Daht\AppleIdLogin;

use Firebase\JWT\JWK;
use Firebase\JWT\JWT;

class AppleIdJWTCheck
{
    private $keys = [];

    function __construct()
    {
        $this->keys = JWK::parseKeySet(json_decode(file_get_contents('https://appleid.apple.com/auth/keys'), true));
    }

    function getKeys()
    {
        return $this->keys;
    }

    public function check($identityToken)
    {
        foreach ($this->keys as $key) {
            try {
                return (array)JWT::decode($identityToken, $key, array('RS256'));
            } catch (\Exception $exception) {
            }
        }
        return [];
    }
}
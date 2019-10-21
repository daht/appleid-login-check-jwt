<?php
namespace Daht\AppleIdLogin;

use chenbool\JWT\JWT;
use CoderCat\JWKToPEM\JWKConverter;

class AppleIdJWTCheck
{
    private  $pubilcKey = "";

    function __construct()
    {
        $jwk = json_decode(file_get_contents('https://appleid.apple.com/auth/keys'), 1)['keys'][0];
        $jwkConverter = new JWKConverter();
        $this->pubilcKey =  $jwkConverter->toPEM($jwk);
    }

    public function check($identityToken){
        $decoded = JWT::decode($identityToken, $this->pubilcKey, array('RS256'));
        $decoded_array = (array)$decoded;
        return  json_encode($decoded_array);
    }
}
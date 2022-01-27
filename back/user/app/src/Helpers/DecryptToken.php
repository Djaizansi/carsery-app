<?php

namespace App\Helpers;

class DecryptToken {
    public function decrypt($token){
        $decodeUser = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $token->getCredentials())[1]))));
        $user = $token->getUser();
        $user->setId($decodeUser->id);
        return $user;
    }
}
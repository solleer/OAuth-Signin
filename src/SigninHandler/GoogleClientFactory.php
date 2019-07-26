<?php

namespace Solleer\OAuthSignin\SigninHandler;

class GoogleClientFactory {
    public function createWithToken(\User\Model\OAuthStatus $status) {
        $client = new \Google_Client();
        if ($status->getOAuthVars() !== []) $client->setAccessToken($status->getOAuthVars());
        return $client;
    }
}
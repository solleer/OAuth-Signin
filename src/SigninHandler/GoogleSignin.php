<?php

namespace Solleer\OAuthSignin\SigninHandler;

class GoogleSignin implements SigninHandler {
    private $service;

    public function __construct(\Google_Service_Oauth2 $service) {
        $this->service = $service;
    }

    public function getOAuthUrl(): string {
        return $this->service->getClient()->createAuthUrl();
    }

    public function getAccessToken($code): array {
        return $this->checkResult($this->service->getClient()->fetchAccessTokenWithAuthCode($code));
    }

    public function getUserId($token): string {
        $this->service->getClient()->setAccessToken($token);
        return $this->service->userinfo->get()->getEmail();
    }

    public function isTokenExpired($token): bool {
        if (empty($token['access_token'])) return true;
        $this->service->getClient()->setAccessToken($token);
        return $this->checkResult($this->service->getClient()->isAccessTokenExpired());
    }

    public function getAccessTokenFromRefresh($token): array {
        if (empty($token['access_token'])) return [];
        return $this->checkResult($this->service->getClient()->fetchAccessTokenWithRefreshToken($token));
    }

    private function checkResult($result) {
        if (isset($result['error'])) return [];
        else return $result;
    }
}
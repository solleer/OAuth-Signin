<?php

namespace Solleer\OAuthSignin\SigninHandler;

class Office365Signin implements SigninHandler {
    private $auth;
    private $graph;

    public function __construct(Office365Auth $auth, \Microsoft\Graph\Graph $graph) {
        $this->auth = $auth;
        $this->graph = $graph;
    }

    public function getOAuthUrl(): string {
        return $this->auth->getProvider()->getAuthorizationUrl();
    }

    public function getAccessToken($code): array {
        $accessToken = $this->auth->getAccessToken($code);
        if ($accessToken === false) return [];
        return [
            'access_token' => $accessToken->getToken(),
            'refresh_token' => $accessToken->getRefreshToken(),
            'token_expires' => $accessToken->getExpires()
        ];
    }

    public function getUserEmail($token): string {
        if (count(explode('.', $token['access_token'])) > 1) return $this->getIdFromToken($token);
        else return $this->getIdFromGraph($token);
    }

    private function getIdFromToken($token) {
        $decodedAccessTokenPayload = base64_decode(
            explode('.', $token['access_token'])[1]
        );
        $jsonAccessTokenPayload = json_decode($decodedAccessTokenPayload, true);
        return $jsonAccessTokenPayload['unique_name'];
    }

    private function getIdFromGraph($token) {
        $result = $this->graph->setAccessToken($token['access_token'])->createRequest('GET', '/me')
            ->execute()->getBody();

        return $result['userPrincipalName'];
    }

    public function isTokenExpired($token): bool {
        return time() > $token['token_expires'];
    }

    public function getAccessTokenFromRefresh($token): array {
        if (!$token['refresh_token']) return [];

        $accessToken = $this->auth->refreshToken($token['refresh_token']);

        if (!$accessToken) return [];

        return [
            'access_token' => $accessToken->getToken(),
            'refresh_token' => false,
            'token_expires' => $accessToken->getExpires()
        ];
    }
}
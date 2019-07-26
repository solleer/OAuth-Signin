<?php
namespace Solleer\OAuthSignin\SigninHandler;
use League\OAuth2\Client\Provider\GenericProvider;
class Office365Auth {
    private $provider;

    public function __construct(GenericProvider $provider) {
        $this->provider = $provider;
    }

    public function getProvider() {
        return $this->provider;
    }

    public function getToken(array $properties) {
        try {
            $accessToken = $this->provider->getAccessToken('authorization_code', $properties);
            return $accessToken;
        }
        catch (\Exception $e) {
            error_log($e);
            return false;
        }
    }

    public function refreshToken($refreshToken) {
        return $this->getToken([
            'refresh_token' => $refreshToken,
            'grant_type' => 'refresh_token'
        ]);
    }
    
    public function getAccessToken($code) {
        try {
            $accessToken = $this->provider->getAccessToken('authorization_code', [
                'code' => $code
            ]);
            return $accessToken;
        }
        catch (\Exception $e) {
            error_log($e);
            return false;
        }
    }
}

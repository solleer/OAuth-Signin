<?php

namespace Solleer\OAuthSignin;

class OAuthStatus {
    public function setOAuthVars(array $vars) {
        $_SESSION['oauth'] = $vars;
        return true;
    }

    public function getOAuthVars() {
        return $_SESSION['oauth'] ?? [];
    }

    public function getAccessToken() {
        return $this->getOAuthVars()['access_token'] ?? null;
    }
}


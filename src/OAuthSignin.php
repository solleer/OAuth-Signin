<?php
namespace Solleer\OAuthSignin;
class OAuthSignin {
    private $model;
    private $users;
    private $userStatus;
    private $oauthStatus;

    public function __construct(SigninHandler\SigninHandler $model, \Solleer\User\User $users,
                                \Solleer\User\SigninStatus $userStatus, OAuthStatus $oauthStatus) {
        $this->model = $model;
        $this->users = $users;
        $this->userStatus = $userStatus;
        $this->oauthStatus = $oauthStatus;
    }

    public function signin($code) {
        $accessToken = $this->model->getAccessToken($code);
        if (empty($accessToken)) return false;

        $email = strtolower($this->model->getUserEmail($accessToken));

        if ($this->users->getUser($email)) {
            $this->oauthStatus->setOAuthVars($accessToken);
            $this->userStatus->setSigninID($email);
            return true;
        }
        else return false;
    }

    public function getOAuthUrl() {
        return $this->model->getOAuthUrl();
    }

    public function signout() {
        $this->oauthStatus->setOAuthVars([]);
        $this->userStatus->setSigninID(null);
        return true;
    }
}

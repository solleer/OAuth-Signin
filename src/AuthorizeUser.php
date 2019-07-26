<?php
namespace Solleer\OAuthSignin;
class AuthorizeUser implements \Solleer\User\Authorizable {
    private $auth;
    private $signin;
    private $status;
    private $request;

    public function __construct(
        SigninHandler\SigninHandler $auth,
        OAuthSignin $signin,
        OAuthStatus $status,
        \Level2\Core\Request $request
    ) {
        $this->auth = $auth;
        $this->signin = $signin;
        $this->status = $status;
        $this->request = $request;
    }

    public function authorize($user, array $args): bool {
        if (empty($user)) return false;
        if ($this->request->get('url') === 'user/signin') return true;

        $status = $this->status->getOAuthVars();
        if (empty($status)) return false;

        if ($this->auth->isTokenExpired($status)) {
            $result = $this->auth->getAccessTokenFromRefresh($status);

            if (empty($result)) {
                $this->signin->signout();
                return false;
            }

            $this->status->setOAuthVars($result);
        }

        return true;
    }
}

<?php

namespace Solleer\OAuthSignin;

class RedirectPath {
    private $onlineBase;
    private $localBase;
    private $path;
    private $isOnline;

    public function __construct($onlineBase, $localBase, $path, bool $isOnline) {
        $this->onlineBase = $onlineBase;
        $this->localBase = $localBase;
        $this->path = $path;
        $this->isOnline = $isOnline;
    }

    public function getOnline() {
        return "https://" . $this->onlineBase . '/' . $this->path;
    }

    public function getLocal() {
        return "http://" . $this->localBase . '/' . $this->path;
    }

    public function getRedirectPath() {
        return $this->isOnline ? $this->getOnline() : $this->getLocal();
    }
}
<?php

namespace Solleer\OAuthSignin\SigninHandler;

interface SigninHandler {
    public function getOAuthUrl(): string;
    public function getAccessToken($code): array;
    public function getUserId($token): string;
    public function isTokenExpired($token): bool;
    public function getAccessTokenFromRefresh($token): array;
}
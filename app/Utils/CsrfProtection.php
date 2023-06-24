<?php

session_start();

class CsrfProtection
{
    protected string $tokenKey = 'csrf_token';

    public function generateToken()
    {
        $token = bin2hex(random_bytes(32)); // Generate a random token
        $_SESSION[$this->tokenKey] = $token; // Store the token in the session
        return $token;
    }

    public function getToken()
    {
        return $_SESSION[$this->tokenKey];
    }

    public function validateToken($token)
    {
        if (isset($_SESSION[$this->tokenKey]) && $_SESSION[$this->tokenKey] === $token) {
            unset($_SESSION[$this->tokenKey]); // Remove the token after validation
            return true;
        }
        return false;
    }
}

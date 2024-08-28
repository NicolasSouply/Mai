<?php

class CSRFTokenManager
{
   
    public function generateCSRFToken(): string
    {
        if(!isset($_SESSION['csrf_token'])) {
        $token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $token;
        } else {
            $token = $_SESSION['csrf_token'];
        }
        return $token;
    }

    public function validateCSRFToken($token) : bool
    {

        if (isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
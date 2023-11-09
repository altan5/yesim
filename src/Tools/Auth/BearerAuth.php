<?php

namespace Altan\YesimTest\Tools\Auth;

/**
 * BearerAuth
 */
class BearerAuth implements AuthInterface
{
    private static $active_tokens = [
        "some_token1"
    ];    
    /**
     * check
     *
     * @return bool
     */
    public function check(): bool
    {
        $token = $this->getBearerToken();
        return array_search($token, self::$active_tokens) !== false;
    }
    
    /**
     * getAuthorizationHeader
     *
     * @return string
     */
    private function getAuthorizationHeader(): ?string
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $request_headers = apache_request_headers();
            $request_headers = array_combine(
                array_map(
                    'ucwords',
                    array_keys($request_headers)
                ),
                array_values($request_headers)
            );
            if (isset($request_headers['Authorization'])) {
                $headers = trim($request_headers['Authorization']);
            }
        }
        return $headers;
    }
    
    /**
     * getBearerToken
     *
     * @return string
     */
    private function getBearerToken(): ?string
    {
        $headers = $this->getAuthorizationHeader();
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }
}

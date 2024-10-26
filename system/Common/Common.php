<?php

    namespace FW\Common;

    class Common {

        public static function baseUrl($path = null) {
            $baseUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
            if ($path) {
                $baseUrl .= '/' . ltrim($path, '/');
            }
            return $baseUrl;
        }
        
        public static function env($key, $default = null) {
            return $_SERVER[$key] ?: $default;
        }
        
        public static function generateRandomString($length = 16) {
            return bin2hex(random_bytes($length / 2));
        }

    }

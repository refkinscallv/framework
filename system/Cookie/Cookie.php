<?php

    namespace FW\Cookie;

    use Exception;

    class Cookie {

        protected $cookieName;
        protected $cookieExpire;
        protected $cookiePath;
        protected $cookieDomain;
        protected $cookieSecure;
        protected $crypto;
        protected $cookieEncrypt;

        public function __construct($db = null) {
            $this->cookieName = $_SERVER["COOKIE_NAME"] ?? "web_cookie";
            $this->cookieExpire = $_SERVER["COOKIE_EXPIRES"] ?? 24;
            $this->cookiePath = $_SERVER["COOKIE_PATH"] ?? "/";
            $this->cookieDomain = $_SERVER["SERVER_NAME"];
            $this->cookieSecure = $_SERVER["COOKIE_SECURE"] ?? false;
            $this->cookieEncrypt = $db ? $this->encryption($db) : false;
        }

        public function all() {
            if (!isset($_COOKIE[$this->cookieName])) {
                return [];
            }

            $cookieData = $_COOKIE[$this->cookieName];

            try {
                if ($this->cookieEncrypt) {
                    return $this->cookieEncrypt->decrypt($cookieData, "array");
                }
                $unserializedData = @unserialize($cookieData);
                if ($unserializedData === false && $cookieData !== 'b:0;') {
                    throw new Exception("Failed to unserialize cookie data.");
                }
                return $unserializedData ?: [];
            } catch (Exception $e) {
                throw new Exception("Failed to retrieve cookies: " . $e->getMessage());
            }
        }

        public function get($key) {
            $allCookie = $this->all();
            return $allCookie[$key] ?? null;
        }

        public function has($key) {
            return $this->get($key) !== null;
        }

        public function set($key, $value = null) {
            $allCookie = $this->all();

            if (is_array($key)) {
                foreach ($key as $idx => $val) {
                    $allCookie[$idx] = $val;
                }
            } else {
                $allCookie[$key] = $value;
            }

            $setCookie = $this->cookieEncrypt ? $this->cookieEncrypt->encrypt($allCookie, "array") : serialize($allCookie);

            if (headers_sent()) {
                throw new Exception("Cannot set cookie; headers already sent.");
            }

            if (!setcookie(
                $this->cookieName,
                $setCookie,
                [
                    'expires' => time() + ($this->cookieExpire * 3600),
                    'path' => $this->cookiePath,
                    'secure' => $this->cookieSecure,
                    'httponly' => true
                ]
            )) {
                throw new Exception("Failed to set cookie: " . $this->cookieName);
            }

            return true;
        }

        public function unset($key) {
            $allCookie = $this->all();

            if (is_array($key)) {
                foreach ($key as $idx) {
                    unset($allCookie[$idx]);
                }
            } else {
                unset($allCookie[$key]);
            }

            $setCookie = $this->cookieEncrypt ? $this->cookieEncrypt->encrypt($allCookie, "array") : serialize($allCookie);

            if (!setcookie(
                $this->cookieName,
                $setCookie,
                [
                    'expires' => time() + ($this->cookieExpire * 3600),
                    'path' => $this->cookiePath,
                    'secure' => $this->cookieSecure,
                    'httponly' => true
                ]
            )) {
                throw new Exception("Failed to unset cookie: " . $this->cookieName);
            }

            return true;
        }

        public function destroy() {
            return setcookie(
                $this->cookieName,
                '',
                [
                    'expires' => time() - 3600,
                    'path' => $this->cookiePath,
                    'secure' => $this->cookieSecure,
                    'httponly' => true
                ]
            );
        }

        public function encryption($db) {
            $this->crypto = $db;
            return $this->crypto;
        }
        
    }

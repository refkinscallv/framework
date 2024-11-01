<?php

    namespace FW\Session;

    class Session {

        protected $sessionTimeout;
        protected $sessionDomain;
        protected $sessionPath;
        protected $sessionSecure;
        protected $sessionName;

        public function __construct() {
            $this->sessionTimeout = ($this->getServerValue("SESSION_TIMEOUT", 1) * 3600);
            $this->sessionDomain = $_SERVER["SERVER_NAME"];
            $this->sessionPath = $this->getServerValue("SESSION_PATH", '/');
            $this->sessionSecure = (bool)$this->getServerValue("SESSION_SECURE", false);
            $this->sessionName = $this->getServerValue("SESSION_NAME", 'web_session');

            $this->checkTimeout();
        }

        private function getServerValue(string $key, $default) {
            return $_SERVER[$key] ?? $default;
        }

        private function checkTimeout() {
            if (isset($_SESSION['LAST_ACTIVITY'])) {
                if ((time() - $_SESSION['LAST_ACTIVITY']) > $this->sessionTimeout) {
                    $this->destroy();
                    return;
                }
            }
            $_SESSION['LAST_ACTIVITY'] = time();
        }

        public function start(): void {
            if (session_status() === PHP_SESSION_NONE) {
                session_set_cookie_params([
                    'lifetime' => $this->sessionTimeout,
                    'path' => $this->sessionPath,
                    'domain' => $this->sessionDomain,
                    'secure' => $this->sessionSecure,
                    'httponly' => !$this->sessionSecure,
                    'samesite' => 'Strict'
                ]);
                session_name($this->sessionName);
                session_start();
            }
        }

        public function set($key, $value = null): void {
            $this->start();
            $this->validateKey($key);

            if (is_array($key)) {
                foreach ($key as $idx => $val) {
                    $_SESSION[$idx] = $val;
                }
            } else {
                $_SESSION[$key] = $value;
            }
        }

        public function get(string $key, $default = null) {
            $this->start();
            $this->validateKey($key);

            return $_SESSION[$key] ?? $default;
        }

        public function some(array $keys, $default = null): array {
            $this->start();
            $values = [];

            foreach ($keys as $key) {
                $this->validateKey($key);
                $values[$key] = $_SESSION[$key] ?? $default;
            }

            return $values;
        }

        public function has(string $key): bool {
            $this->start();
            $this->validateKey($key);

            return isset($_SESSION[$key]);
        }

        public function remove(string $key): void {
            $this->start();
            $this->validateKey($key);

            unset($_SESSION[$key]);
        }

        public function setFlash(string $key, $value): void {
            $this->start();
            $this->validateKey($key);

            $_SESSION['flash_data'][$key] = $value;
        }

        public function getFlash(string $key, $default = null) {
            $this->start();
            $this->validateKey($key);

            $value = $_SESSION['flash_data'][$key] ?? $default;
            $this->removeFlash($key);

            return $value;
        }

        private function removeFlash(string $key): void {
            unset($_SESSION['flash_data'][$key]);
        }

        public function clear(): void {
            $this->start();
            session_unset();
        }

        public function destroy(): void {
            $this->start();
            session_destroy();
        }

        private function validateKey(string $key): void {
            if (empty($key) || !is_string($key)) {
                throw new \InvalidArgumentException("Session key must be a non-empty string.");
            }
        }
        
    }

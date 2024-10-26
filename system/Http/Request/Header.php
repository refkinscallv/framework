<?php

    namespace FW\Http\Request;

    use Exception;

    class Header {

        public function all() {
            return $this->getAllHeaders();
        }

        public function has($name) {
            $headers = $this->all();
            return array_key_exists($name, $headers);
        }

        public function get($name) {
            $headers = $this->all();
            if (!$this->has($name)) {
                throw new Exception("Header '{$name}' not found.");
            }
            return $headers[$name];
        }

        public function set($name, $value) {
            if (empty($name) || empty($value)) {
                throw new Exception("Header name and value cannot be empty.");
            }
            header("$name: $value");
        }

        public function remove(string $name) {
            if (!$this->has($name)) {
                throw new Exception("Header '{$name}' cannot be removed because it does not exist.");
            }
            header_remove($name);
        }

        private function getAllHeaders() {
            $headers = [];
            foreach ($_SERVER as $key => $value) {
                if (strpos($key, 'HTTP_') === 0) {
                    $header = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))));
                    $headers[$header] = $value;
                }
            }
            return $headers;
        }
    }

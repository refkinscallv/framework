<?php

    namespace FW\Http\Request;

    use FW\Http\Helper;
    use Exception;

    class Query {

        private $query;
        private $filteredQuery = false;

        public function __construct() {
            $this->query = $this->manageData($_GET);
        }

        private function manageData($data) {
            if (!is_array($data)) {
                throw new Exception("Expected input to be an array, received " . gettype($data));
            }

            $newData = [];

            foreach ($data as $key => $value) {
                $sanitizedKey = Helper::sanitize($key);
                $sanitizedValue = Helper::sanitize($value);
                $newData[$sanitizedKey] = $sanitizedValue;
            }

            return $newData;
        }

        public function all() {
            return $this->query;
        }

        public function get($key) {
            if (!$this->has($key)) {
                return false;
            }
            return $this->query[$key];
        }

        public function has($key) {
            return isset($this->query[$key]);
        }

        public function some($keys) {
            if (!is_array($keys)) {
                throw new Exception("Expected keys to be an array, received " . gettype($keys));
            }
            $this->filteredQuery = Helper::filterArrayKeys($this->query, $keys);
            return $this->filteredQuery;
        }

        public function someRecursive($keys) {
            if (!is_array($keys)) {
                throw new Exception("Expected keys to be an array, received " . gettype($keys));
            }
            $this->filteredQuery = Helper::filterArrayKeysRecursive($this->query, $keys);
            return $this->filteredQuery;
        }

        public function count() {
            return [
                "total" => count($this->query),
                "filtered" => $this->filteredQuery ? count($this->filteredQuery) : 0
            ];
        }
    }

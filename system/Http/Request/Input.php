<?php

    namespace FW\Http\Request;

    use FW\Http\Helper;
    use Exception;

    class Input {

        private $input;
        private $filteredInput = false;

        public function __construct() {
            $this->input = $this->manageData($_POST);

            if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
                parse_str(file_get_contents('php://input'), $putData);
                $this->input = $this->manageData($putData);
            }
        }

        private function manageData($data) {
            if (!is_array($data)) {
                throw new Exception("Expected input data to be an array, received " . gettype($data));
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
            return $this->input;
        }

        public function get($key) {
            if (!$this->has($key)) {
                return false;
            }
            return $this->input[$key];
        }

        public function has($key) {
            return isset($this->input[$key]);
        }

        public function some($keys) {
            if (!is_array($keys)) {
                throw new Exception("Expected keys to be an array, received " . gettype($keys));
            }
            $this->filteredInput = Helper::filterArrayKeys($this->input, $keys);
            return $this->filteredInput;
        }

        public function someRecursive($keys) {
            if (!is_array($keys)) {
                throw new Exception("Expected keys to be an array, received " . gettype($keys));
            }
            $this->filteredInput = Helper::filterArrayKeysRecursive($this->input, $keys);
            return $this->filteredInput;
        }

        public function count() {
            return [
                "total" => count($this->input),
                "filtered" => $this->filteredInput ? count($this->filteredInput) : 0
            ];
        }
    }

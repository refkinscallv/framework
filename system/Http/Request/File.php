<?php

    namespace FW\Http\Request;

    use Exception;

    class File {

        private $files;

        public function __construct() {
            $this->files = $_FILES;
        }

        public function all() {
            return $this->files;
        }

        public function has($name) {
            return isset($this->files[$name]);
        }

        public function get($name) {
            if (!$this->has($name)) {
                return false;
            }
            return $this->files[$name];
        }
        
        public function move($name, $destination) {
            if (!$this->has($name)) {
                throw new Exception("File '{$name}' does not exist.");
            }

            if (!is_uploaded_file($this->files[$name]['tmp_name'])) {
                throw new Exception("File '{$name}' is not a valid uploaded file.");
            }

            if (!move_uploaded_file($this->files[$name]['tmp_name'], $destination)) {
                throw new Exception("Failed to move the uploaded file '{$name}' to '{$destination}'.");
            }

            return true;
        }

        public function getOriginalName($name) {
            return $this->has($name) ? $this->files[$name]['name'] : null;
        }

        public function getSize($name) {
            return $this->has($name) ? $this->files[$name]['size'] : null;
        }

        public function getMimeType($name) {
            return $this->has($name) ? $this->files[$name]['type'] : null;
        }

        public function getError($name) {
            return $this->has($name) ? $this->files[$name]['error'] : null;
        }

    }

<?php

    namespace FW\Http;

    use FW\Common\FileSystem;
    use Exception;

    class Response {

        public $viewData;

        public function __construct() {
            $this->viewData = [];
        }

        public function withHttpResponseCode($code) {
            http_response_code((int) $code);
            return $this;
        }

        public function withHeaders($key, $val = null) {
            if (is_array($key)) {
                foreach ($key as $xKey => $xVal) {
                    header($xKey . ": " . $xVal);
                }
            } else {
                header($key . ": " . $val);
            }
            return $this;
        }

        public function view($file, $data = []) {
            if (!file_exists($file . ".php")) {
                throw new Exception("View file not found: " . $file . ".php");
            }

            $this->viewData = array_merge($this->viewData, $data);
            
            extract($this->viewData);
            
            include FileSystem::docRoot("/public/views/" . $file . ".php");
        }

        public function json($data, $flag = JSON_UNESCAPED_SLASHES) {
            $this->withHeaders("content-type", "application/json");
            echo json_encode($data, $flag);
        }
        
        public function custom($content, $type = "text/plain", $isFile = false) {
            $this->withHeaders("content-type", $type);
            if (!$isFile) {
                echo $content;
            } else {
                if (!file_exists(FileSystem::docRoot("/" . $content))) {
                    throw new Exception("File not found: " . $content);
                }
                include FileSystem::docRoot("/" . $content);
            }
        }

        public function redirect($uri) {
            $this->withHeaders("Location", $uri);
            exit();
        }
        
    }

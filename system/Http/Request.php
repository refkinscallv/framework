<?php

    namespace FW\Http;

    use FW\Http\Request\Factory;

    class Request extends Factory {

        public function __construct() {
            parent::__construct();
        }

        public function getMethod() {
            return $_SERVER["REQUEST_METHOD"];
        }

    }
<?php

    namespace FW\Package;

    use Dotenv\Dotenv AS PHPDotenv;

    class Dotenv {

        public function set($documentRoot) {
            PHPDotenv::createImmutable($documentRoot)->load();
        }

    }
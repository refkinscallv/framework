<?php

    namespace FW\Package;

    use Dotenv\Dotenv AS PHPDotenv;

    class Dotenv {

        public function set($documentRoot) {
            if(file_exists($documentRoot . "/.env")) {
                PHPDotenv::createImmutable($documentRoot)->load();
            } else {
                $customText = "<b><small>Please run command 'php fw build'</small></b>";
                include $documentRoot ."/public/views/default.php";
                die();
            }
        }

    }
    
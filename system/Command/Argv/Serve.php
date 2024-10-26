<?php

    namespace FW\Command\Argv;

    class Serve {
        
        public static function run($helper) {
            $dependenciesFile = "vendor/autoload.php";
            if (!file_exists($dependenciesFile)) {
                $helper::label("Framework")
                    ->font("red", "", "bold")
                    ->exec("Please install dependencies first with command 'php fw build'.");
                die();
            }

            $helper::label("Framework")
                ->font("blue", "", "bold")
                ->exec("Local Server Running On: http://127.0.0.1:8080.");
            $helper::label("Framework")
                ->font("yellow", "", "bold")
                ->exec("Press 'CTRL + C' to stop local server.");
                $helper::exec("php -S 127.0.0.1:8080", true);
        }

    }

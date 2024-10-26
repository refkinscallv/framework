<?php

    namespace FW\Command\Argv;

    class Build {

        public static function run($helper, $type) {
            
            $dependenciesFile = "vendor/autoload.php";
            
            if($type === "build") {
                if (file_exists($dependenciesFile)) {
                    $helper::label("Framework")
                        ::font("yellow", "", "bold")
                        ::exec("Dependencies installed. Your application is ready to use.");
                    self::vendorHtaccess($helper);
                    self::configEnv($helper);
                    $helper::label("Framework")
                        ::font("yellow", "", "bold")
                        ::exec("Please run the 'php fw serve' command to run the application.");
                } else {
                    $helper::label("Framework")
                        ::font("blue", "", "bold")
                        ::exec("Please wait. Installing dependencies.");
                    $helper::exec("composer install", true);
                    $helper::label("Framework")
                        ::font("green", "", "bold")
                        ::exec("Dependencies successfully installed.");
                        self::vendorHtaccess($helper);
                        self::configEnv($helper);
                    $helper::label("Framework")
                        ::font("yellow", "", "bold")
                        ::exec("Please run the 'php fw serve' command to run the application.");
                }
            } else {
                if (file_exists($dependenciesFile)) {
                    $helper::label("Framework")
                        ::font("blue", "", "bold")
                        ::exec("Update your dependencies.");
                    $helper::label("Framework")
                        ::font("yellow", "", "bold")
                        ::exec("Please run the 'php fw serve' command to run the application.");
                    $helper::exec("composer update", true);
                    $helper::label("Framework")
                        ::font("green", "", "bold")
                        ::exec("Updating dependencies successful.");
                    self::vendorHtaccess($helper);
                    self::configEnv($helper);
                    $helper::label("Framework")
                        ::font("yellow", "", "bold")
                        ::exec("Please run the 'php fw serve' command to run the application.");
                } else {
                    $helper::label("Framework")
                        ::font("red", "", "bold")
                        ::exec("Please install dependencies first with command 'php fw build'.");
                }
            }
        }

        public static function vendorHtaccess($helper) {
            if (!file_exists('vendor/.htaccess')) {
                $code = <<<'HTACCESS'
                    <IfModule authz_core_module>
                        Require all denied
                    </IfModule>
                    <IfModule !authz_core_module>
                        Deny from all
                    </IfModule>
                    HTACCESS;
                
                file_put_contents('vendor/.htaccess', $code);
                $helper::label("Framework")
                    ::font("green", "", "bold")
                    ::exec(".htaccess file created in vendor directory.");
            }
        }

        public static function configEnv($helper) {
            if(!file_exists(".env")) {
                $helper::exec("cp .env.example .env", true);
                $helper::label("Framework")
                    ::font("green", "", "bold")
                    ::exec(".env config file successfully created.");
            }
        }

    }

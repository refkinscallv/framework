<?php

    namespace FW\Command\Argv;

    class Help {

        public static function run($helper) {
            $commands = [
                ["serve", "Start the built-in server."],
                ["build", "Set up the application (e.g., install dependencies)."],
                ["update", "Update application dependencies."],
                ["make:controller <ControllerName> <Location : default / as app/Controllers>", "Generate a new controller class file in 'app/Controllers' folder."],
                ["make:middleware <MiddlewareName> <Location : default / as app/Middlewares>", "Generate a new middleware class file in 'app/Middlewares' folder."],
                ["make:service <ServiceName> <Location : default / as app/Services>", "Generate a new service class file in 'app/Services' folder."],
                ["make:model <ModelName> <Location : default / as app/Models>", "Generate a new model class file in 'app/Models' folder."],
                ["help", "Display all available commands."]
            ];

            $helper::font("yellow", "", "bold")
                ->exec("");
            $helper::label("Available Commands")
                ->font("green", "", "bold")
                ->exec(" : ");
            $helper::font("yellow", "", "bold")
                ->exec("");

            foreach ($commands as $command) {
                $helper::font("blue", "", "bold")
                    ->exec("php fw " . $command[0]);

                $helper::font("white")
                    ->exec("  - " . $command[1]);
            }

            // $helper::label("Note")
            //     ->font("yellow", "", "bold")
            //     ->exec("Use 'php fw [command] --help' for more information on a specific command.");
            $helper::font("yellow", "", "bold")
                ->exec("");
        }
    }

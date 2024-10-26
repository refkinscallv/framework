<?php

    namespace FW\Package;

    use Spatie\Ignition\Ignition AS SpatieIgnition;

    class Ignition {

        public function set($documentRoot) {
            if(!isset($_SERVER["APP_ENV"]) || $_SERVER["APP_ENV"] === "production") {
                error_reporting(0);
                return;
            }

            error_reporting(-1);

            SpatieIgnition::make()
                ->applicationPath($documentRoot)
                ->useDarkMode()
                ->shouldDisplayException(true)
                ->register();
        }

    }
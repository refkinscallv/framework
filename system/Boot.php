<?php

    namespace FW;

    use FW\Package\Dotenv;
    use FW\Package\Ignition;
    use FW\Package\Eloquent;
    use FW\Common\FileSystem;
    use FW\Router\Route;
    use Illuminate\Support\Facades\Facade;

    class Boot {

        private static Dotenv $dotenv;
        private static Ignition $ignition;
        private static Eloquent $eloquent;

        public static function init() {
            self::$dotenv = new Dotenv();
            self::$ignition = new Ignition();
            self::$eloquent = new Eloquent();
        }

        public static function run() {
            self::init();

            self::$dotenv->set(FileSystem::docRoot());
            self::$ignition->set(FileSystem::docRoot());
            self::$eloquent->set();

            self::postSystem();
        }

        public static function postSystem() {
            // set routing
            require FileSystem::docRoot("/app/Routes/Route.php");
            Route::run();
        }

    }
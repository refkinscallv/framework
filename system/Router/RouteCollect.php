<?php

    namespace FW\Router;

    class RouteCollect {

        private static $routes = [];

        public static function init($routes, $callback) {
            self::$routes = $routes;
            $callback(self::$routes);
        }

    }
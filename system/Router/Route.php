<?php

    namespace FW\Router;

    use FW\Router\RouteCollect as Collect;
    use FW\Router\RouteMiddleware as Middleware;
    use FW\Router\RouteExecution as Execution;
    use FW\Common\FileSystem;

    class Route {

        private static $storage = [];
        private static $prefix = "";

        public static function middleware($callback) {
            self::$storage['middleware'] = self::$storage['middleware'] ?? [];
            self::$storage['middleware'][] = $callback;
            return new self();
        }

        public static function register(array $list = []) {
            if (!empty($list)) {
                foreach ($list as $val) {
                    $filePath = FileSystem::docRoot("/app/Routes" . $val . ".php");
                    if (file_exists($filePath)) {
                        require $filePath;
                    } else {
                        throw new \Exception("Route file '{$val}.php' not found.");
                    }
                }
            }
        }

        public static function setMaintenance($callUserFunc) {
            if (is_callable($callUserFunc) || is_array($callUserFunc)) {
                self::$storage["maintenance"] = ["callback" => $callUserFunc];
            } else {
                throw new \InvalidArgumentException("Invalid maintenance callback provided.");
            }
        }

        public static function set404($callUserFunc) {
            if (is_callable($callUserFunc) || is_array($callUserFunc)) {
                self::$storage["404"] = ["callback" => $callUserFunc];
            } else {
                throw new \InvalidArgumentException("Invalid 404 callback provided.");
            }
        }

        public static function group(array $attr, callable $callback) {
            $prevPrefix = self::$prefix;
            self::$prefix = rtrim($prevPrefix . ($attr["prefix"] ?? ""), "/");

            $callback();

            self::$prefix = $prevPrefix;
        }

        private static function applyPrefix($path) {
            return self::$prefix . '/' . ltrim($path, '/');
        }

        public static function set($path, $callUserFunc, $method = "GET") {
            $path = self::applyPrefix($path);
            self::$storage["routes"][$path] = [
                "callback" => $callUserFunc,
                "method" => $method
            ];
        }

        public static function get($path, $callUserFunc) {
            self::set($path, $callUserFunc, 'GET');
        }

        public static function post($path, $callUserFunc) {
            self::set($path, $callUserFunc, 'POST');
        }

        public static function put($path, $callUserFunc) {
            self::set($path, $callUserFunc, 'PUT');
        }

        public static function delete($path, $callUserFunc) {
            self::set($path, $callUserFunc, 'DELETE');
        }

        public static function patch($path, $callUserFunc) {
            self::set($path, $callUserFunc, 'PATCH');
        }

        public static function options($path, $callUserFunc) {
            self::set($path, $callUserFunc, 'OPTIONS');
        }

        public static function run() {
            Collect::init(self::$storage, function($routes) {
                Middleware::init($routes);
                Execution::init($routes);
            });
        }

    }

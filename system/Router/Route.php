<?php

    namespace FW\Router;

    use FW\Router\RouteCollect as Collect;
    use FW\Router\RouteExecution as Execution;
    use FW\Common\FileSystem;

    class Route {

        private static $storage = [];
        private static $prefix = "";
        private static $groupMiddleware = [];

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

        public static function group(array $attributes, callable $callback) {
            $previousPrefix = self::$prefix;
            self::$prefix .= $attributes['prefix'] ?? '';
            self::$groupMiddleware = $attributes['middleware'] ?? [];
    
            $callback();
    
            self::$prefix = $previousPrefix;
            self::$groupMiddleware = [];
        }

        private static function applyPrefix($path) {
            return self::$prefix . '/' . ltrim($path, '/');
        }

        private static function set($path, $callUserFunc, $method = "GET", $middleware = []) {
            $path = self::applyPrefix($path);
            self::$storage["routes"][$path] = [
                'method' => $method,
                'callback' => $callUserFunc,
                'middleware' => array_merge(self::$groupMiddleware, $middleware)
            ];
        }

        public static function get($path, $callUserFunc, $middleware = []) {
            self::set($path, $callUserFunc, 'GET', $middleware);
        }

        public static function post($path, $callUserFunc, $middleware = []) {
            self::set($path, $callUserFunc, 'POST', $middleware);
        }

        public static function put($path, $callUserFunc, $middleware = []) {
            self::set($path, $callUserFunc, 'PUT', $middleware);
        }

        public static function delete($path, $callUserFunc, $middleware = []) {
            self::set($path, $callUserFunc, 'DELETE', $middleware);
        }

        public static function patch($path, $callUserFunc, $middleware = []) {
            self::set($path, $callUserFunc, 'PATCH', $middleware);
        }

        public static function options($path, $callUserFunc, $middleware = []) {
            self::set($path, $callUserFunc, 'OPTIONS', $middleware);
        }

        public static function run() {
            Collect::init(self::$storage, function($routes) {
                Execution::init($routes);
            });
        }

    }

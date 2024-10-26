<?php

    namespace FW\Router;

    class RouteExecution {

        private static $routes = [];

        public static function init($routes) {
            self::$routes = $routes;

            if (isset($routes['maintenance'])) {
                self::callFunction($routes['maintenance']['callback']);
                return;
            }

            $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $requestMethod = $_SERVER['REQUEST_METHOD'];

            foreach ($routes['routes'] as $path => $route) {
                $params = [];
                if (self::matchRoute($path, $requestUri, $params)) {
                    if ($route['method'] === strtoupper($requestMethod)) {
                        $callbackParams = self::prepareCallbackParams($route['callback'], $params);
                        self::callFunction($route['callback'], $callbackParams);
                        return;
                    }
                }
            }

            if (isset($routes['404'])) {
                self::callFunction($routes['404']['callback']);
            } else {
                header("HTTP/1.0 404 Not Found");
                echo "404 Not Found";
            }
        }

        private static function matchRoute($path, $uri, &$params) {
            $pathParts = explode("/", trim($path, "/"));
            $uriParts = explode("/", trim($uri, "/"));

            if (count($pathParts) < count($uriParts)) {
                return false;
            }

            $params = [];
            
            foreach ($pathParts as $index => $part) {
                if (self::isPlaceholder($part)) {
                    $params[] = self::sanitize($uriParts[$index] ?? '');
                } elseif ($part !== $uriParts[$index]) {
                    return false;
                }
            }

            return true;
        }

        private static function isPlaceholder($part) {
            return strpos($part, '{') === 0 && strpos($part, '}') === strlen($part) - 1;
        }

        private static function prepareCallbackParams($callback, $params) {
            $callbackParams = [];
            
            $reflection = new \ReflectionFunction($callback);
            $numParams = $reflection->getNumberOfParameters();

            if ($numParams > 0) {
                $callbackParams = array_slice($params, 0, $numParams);
            }
            
            return $callbackParams;
        }

        private static function callFunction($callback, $params = []) {
            if (is_callable($callback)) {
                call_user_func_array($callback, $params);
            } elseif (is_array($callback) && class_exists($callback[0]) && method_exists($callback[0], $callback[1])) {
                call_user_func_array([new $callback[0], $callback[1]], $params);
            } else {
                throw new \InvalidArgumentException("Invalid callback provided.");
            }
        }

        private static function sanitize($input) {
            return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
        }

    }

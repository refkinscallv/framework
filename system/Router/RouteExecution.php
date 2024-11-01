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
                        if (!empty($route['middleware'])) {
                            if (!is_array($route['middleware']) || count($route['middleware']) !== 2) {
                                throw new \InvalidArgumentException("Middleware must be an array with two elements: [class, method].");
                            }
                        
                            $mwClass = $route['middleware'][0];
                            $mwMethod = $route['middleware'][1];
                        
                            if (!class_exists($mwClass) || !method_exists($mwClass, $mwMethod)) {
                                throw new \InvalidArgumentException("Invalid middleware class or method: '{$mwClass}::{$mwMethod}'.");
                            }
                        
                            $middleware = new $mwClass(new \FW\Http\Request(), new \FW\Http\Response());
                            $middleware->{$mwMethod}();
                        }
                        
    
                        $callbackParams = self::prepareCallbackParams($route['callback'], $params);
                        self::callFunction($route['callback'], $callbackParams);
                        return;
                    }
                }
            }
    
            if (isset($routes['404'])) {
                header("HTTP/1.0 404 Not Found");
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
                    if (isset($uriParts[$index])) {
                        $params[] = self::sanitize($uriParts[$index]);
                    } elseif (self::isOptionalPlaceholder($part)) {
                        $params[] = '';
                    } else {
                        return false;
                    }
                } elseif ($part !== $uriParts[$index]) {
                    return false;
                }
            }

            return true;
        }

        private static function isPlaceholder($part) {
            return strpos($part, '{') === 0 && strpos($part, '}') === strlen($part) - 1;
        }

        private static function isOptionalPlaceholder($part) {
            return strpos($part, '?}') !== false;
        }

        private static function prepareCallbackParams($callback, $params) {
            $callbackParams = [];

            if (is_array($callback)) {
                $reflection = new \ReflectionMethod($callback[0], $callback[1]);
            } else {
                $reflection = new \ReflectionFunction($callback);
            }

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

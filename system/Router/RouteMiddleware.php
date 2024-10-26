<?php

    namespace FW\Router;

    use FW\Http\Request;
    use FW\Http\Response;

    class RouteMiddleware {

        private static $routes = [];

        public static function init($routes) {
            self::$routes = $routes;

            foreach (self::$routes['routes'] as $path => $route) {
                self::applyMiddleware($route);
            }
        }

        private static function applyMiddleware($route) {
            $middleware = self::$routes['middleware'] ?? [];
            foreach ($middleware as $mw) {
                if (is_callable($mw)) {
                    $params = [new Request(), new Response()];
                    self::callFunction($mw, $params);
                } else {
                    throw new \InvalidArgumentException("Middleware must be callable.");
                }
            }
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

    }

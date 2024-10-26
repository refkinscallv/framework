<?php

    namespace FW\Http;

    use Exception;

    class Helper {

        public static function sanitize($input) {
            if (is_array($input)) {
                $sanitized_array = [];

                foreach ($input as $key => $value) {
                    $sanitized_key = htmlspecialchars(trim($key), ENT_QUOTES, 'UTF-8');
                    $sanitized_value = self::sanitize($value);
                    $sanitized_array[$sanitized_key] = $sanitized_value;
                }
                
                return $sanitized_array;
            } else {
                if (!is_string($input)) {
                    throw new Exception("Invalid input type for sanitization. Expected string or array.");
                }
                return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
            }
        }

        public static function filterArrayKeys($array, $keysToKeep) {
            if (!is_array($array) || !is_array($keysToKeep)) {
                throw new Exception("Invalid input types. Expected arrays for both parameters.");
            }

            return array_filter(
                $array,
                function ($key) use ($keysToKeep) {
                    return in_array($key, $keysToKeep);
                },
                ARRAY_FILTER_USE_KEY
            );
        }

        public static function filterArrayKeysRecursive($array, $keysToKeep) {
            if (!is_array($array) || !is_array($keysToKeep)) {
                throw new Exception("Invalid input types. Expected arrays for both parameters.");
            }

            $filteredArray = array_filter(
                $array,
                function ($key) use ($keysToKeep) {
                    return in_array($key, $keysToKeep);
                },
                ARRAY_FILTER_USE_KEY
            );

            foreach ($filteredArray as &$value) {
                if (is_array($value)) {
                    $value = self::filterArrayKeysRecursive($value, $keysToKeep);
                }
            }

            return $filteredArray;
        }
        
        public static function countArrayKeys($array, $recursive = false) {
            if (!is_array($array)) {
                throw new Exception("Invalid input type. Expected an array.");
            }

            $totalCount = 0;

            $countFunction = function(array $array, &$totalCount) use (&$countFunction, $recursive) {
                foreach ($array as $key => $value) {
                    $totalCount++;
                    if ($recursive && is_array($value)) {
                        $countFunction($value, $totalCount);
                    }
                }
            };

            $countFunction($array, $totalCount);
            return $totalCount;
        }

    }

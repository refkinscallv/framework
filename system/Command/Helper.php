<?php

    namespace FW\Command;

    class Helper {
        
        public static $color = [
            'black' => "\033[30m",
            'red' => "\033[31m",
            'green' => "\033[32m",
            'yellow' => "\033[33m",
            'blue' => "\033[34m",
            'magenta' => "\033[35m",
            'cyan' => "\033[36m",
            'white' => "\033[37m",
            'bg_black' => "\033[40m",
            'bg_red' => "\033[41m",
            'bg_green' => "\033[42m",
            'bg_yellow' => "\033[43m",
            'bg_blue' => "\033[44m",
            'bg_magenta' => "\033[45m",
            'bg_cyan' => "\033[46m",
            'bg_white' => "\033[47m",
            'bold' => "\033[1m",
            'underline' => "\033[4m",
            'reversed' => "\033[7m",
        ];

        private static $setColor = '';
        private static $setTime = '';
        private static $setLabel = '';

        public static function font($color = '', $background = '', $style = '') {
            self::$setColor = self::$color[$color] ?? '';
            self::$setColor .= self::$color[$background] ?? '';
            self::$setColor .= self::$color[$style] ?? '';

            return new self;
        }

        public static function time() {
            self::$setTime = "[" . date("Y-m-d H:i:s") . "] ";

            return new self;
        }

        public static function label($str) {
            self::$setLabel = "[" . $str . "] ";

            return new self;
        }

        public static function exec($input, $passthru = false) {
            $output = self::$setTime . self::$setLabel . $input;

            if ($passthru) {
                exec($input . PHP_EOL);
            } else {
                echo self::$setColor . $output . "\033[0m" . PHP_EOL;
            }

            self::$setColor = '';
            self::$setTime = '';
            self::$setLabel = '';
        }
        
    }

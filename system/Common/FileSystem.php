<?php

    namespace FW\Common;

    class FileSystem {

        public static function docRoot($path = "") {
            return $_SERVER["DOCUMENT_ROOT"] . $path;
        }

    }

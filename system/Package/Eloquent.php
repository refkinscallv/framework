<?php

    namespace FW\Package;

    use Illuminate\Database\Capsule\Manager AS Capsule;

    class Eloquent {

        private Capsule $capsule;

        public function __construct() {
            $this->capsule = new Capsule();
        }

        public function set() {
            $this->capsule->addConnection([
                "driver"        => $_SERVER["DB_DRIVER"] ?? "mysql",
                "host"          => $_SERVER["DB_HOST"],
                "database"      => $_SERVER["DB_NAME"],
                "username"      => $_SERVER["DB_USER"],
                "password"      => $_SERVER["DB_PASS"],
                "charset"       => $_SERVER["DB_CHARSET"] ?? "utf8",
                "collation"     => $_SERVER["DB_COLLATION"] ?? "utf8_unicode_ci",
                "prefix"        => $_SERVER["DB_PREFIX"] ?? ""
            ]);

            $this->capsule->setAsGlobal();
            $this->capsule->bootEloquent();
        }

        public function instance() {
            return $this->capsule;
        }

    }

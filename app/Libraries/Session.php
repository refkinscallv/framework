<?php

    namespace FW\App\Libraries;

    use FW\Session\Session AS RFSession;

    class Session {

        private $sessionInstance;

        public function __construct() {
            $this->sessionInstance = new RFSession();
        }

        public function instance() {
            return $this->sessionInstance;
        }

    }

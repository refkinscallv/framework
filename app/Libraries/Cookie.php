<?php

    namespace FW\App\Libraries;

    use FW\Cookie\Cookie AS RFCookie;
    use FW\App\Libraries\Crypto;

    class Cookie {

        private $cookieInstance;

        private Crypto $crypto;

        public function __construct() {
            if($_SERVER["COOKIE_ENCRYPT"]) {
                $this->crypto = new Crypto($_SERVER["COOKIE_FILE"]);
                $this->cookieInstance = new RFCookie($this->crypto->instance());
            } else {
                $this->cookieInstance = new RFCookie();
            }
        }

        public function instance() {
            return $this->cookieInstance;
        }

    }

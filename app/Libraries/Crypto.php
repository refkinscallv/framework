<?php

    namespace FW\App\Libraries;

    use FW\Security\Crypto as RFCrypto;
    use FW\App\Services\CryptoService;

    class Crypto {

        private $cryptoInstance;
        private CryptoService $cryptoService;

        public function __construct($setFile = null) {
            
            $cryptStore = $_SERVER["ENCRYPT_STORE"] ?? "local";
            $this->cryptoService = new CryptoService();

            if ($cryptStore === "local") {
                $this->cryptoInstance = new RFCrypto();
                
                if($setFile) {
                    $this->cryptoInstance->setFile($setFile);
                }
            } else {
                $this->cryptoInstance = new RFCrypto($this->getDatabaseHandler());
            }
        }

        private function getDatabaseHandler() {
            $service = $this->cryptoService;
            return function($data, $mode) use ($service) {
                if ($mode === "write") {
                    return $service->encrypt($data);
                } else if ($mode === "read") {
                    return $service->decrypt($data);
                }
                return false;
            };
        }

        public function instance() {
            return $this->cryptoInstance;
        }

    }

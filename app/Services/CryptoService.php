<?php

    namespace FW\App\Services;

    use FW\App\Models\CryptoModel;
    use Exception;

    class CryptoService {

        private CryptoModel $cryptoModel;

        public function __construct() {
            $this->cryptoModel = new CryptoModel();
        }

        public function encrypt($data) {
            try {
                $rawData = explode(":", $data);

                $this->cryptoModel->md5 = $rawData[1];
                $this->cryptoModel->base64 = $rawData[0];

                $this->cryptoModel->save();

                return $rawData[1];
            } catch (Exception $e) {
                return false;
            }
        }

        public function decrypt($data) {
            try {
                $crypto = CryptoModel::where("md5", $data)->first();

                if(!$crypto) {
                    return false;
                }

                return $crypto->base64;
            } catch (Exception $e) {
                return false;
            }
        }
        
    }

<?php

    namespace FW\App\Services;
    
    use FW\Base;

    class BaseService extends Base {

        public function __construct() {
            
            parent::__construct();
            
        }

        public function result($status = true, $code = 200, $message = null, $result = null, $custom = []): array {
            $defaultResponse = [
                "status" => $status,
                "code" => $code,
                "message" => $message,
                "result" => $result
            ];
            
            if(is_array($custom) && !empty($custom)) {
                return array_merge($defaultResponse, $custom);
            }

            return $defaultResponse;
        }

    }

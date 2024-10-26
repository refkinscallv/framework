<?php

    namespace FW\Http;

    use CG\FVSS\Fvss;
    use Exception;

    class Validation {

        private Fvss $validator;

        public function __construct() {
            $this->validator = new Fvss();
        }

        public function validate($data) {
            try {
                $result = $this->validator->validate($data);
                if ($result === false) {
                    throw new Exception("Validation failed.");
                }
                return $result;
            } catch (Exception $e) {
                throw new Exception("Validation error: " . $e->getMessage());
            }
        }
    }

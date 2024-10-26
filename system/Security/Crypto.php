<?php

    namespace FW\Security;

    use FW\Common\FileSystem;
    use Exception;

    class Crypto {

        private $cryptSecretKey;
        private $cryptFile;
        private $cryptLimitLine;
        private $cryptCipherAlgo;
        private $cryptStoreMethod;
        private $dbhandler;

        public function __construct($db = null) {
            $this->cryptSecretKey = $_SERVER["ENCRYPT_KEY"];
            $this->cryptFile = FileSystem::docRoot($_SERVER["ENCRYPT_FILE"]);
            $this->cryptLimitLine = $_SERVER["ENCRYPT_LIMIT"] ?? 1000;
            $this->cryptCipherAlgo = $_SERVER["ENCRYPT_CIPHER"] ?? "AES-256-CBC";
            $this->cryptStoreMethod = $_SERVER["ENCRYPT_STORE"] ?? "local";
            $this->dbhandler = $db ?? null; 

            $this->initializeStorage();
        }

        private function initializeStorage() {
            if ($this->cryptStoreMethod === "local" && $this->cryptFile) {
                $defaultDir = dirname($this->cryptFile);
                if (!is_dir($defaultDir)) {
                    mkdir($defaultDir, 0777, true);
                }

                if (!file_exists($this->cryptFile)) {
                    file_put_contents($this->cryptFile, "");
                }
            } elseif ($this->cryptStoreMethod === "database" && !$this->dbhandler) { 
                throw new Exception("Database handler not provided for 'database' storage method.");
            }
        }

        public function setFile($filePath) {
            $this->cryptFile = FileSystem::docRoot($filePath);
        }

        public function encrypt($data, $type = "string") {
            if (empty($data)) {
                return false;
            }

            if ($type === "array") {
                $data = serialize($data);
            }

            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cryptCipherAlgo));
            $encryptedData = openssl_encrypt($data, $this->cryptCipherAlgo, $this->cryptSecretKey, 0, $iv);
            $base64Encoded = base64_encode($encryptedData . "::" . $iv);
            $md5hash = md5($base64Encoded);

            $this->translatingCrypto($base64Encoded . ":" . $md5hash, "write");

            return $md5hash;
        }

        public function decrypt($data, $type = "string") {
            if (empty($data)) {
                return false;
            }
        
            $data = $this->translatingCrypto($data, "read");
            $decodedData = explode("::", base64_decode($data), 2);
            
            if (count($decodedData) !== 2) {
                return false;
            }
        
            [$encryptedData, $iv] = $decodedData;
        
            if (empty($iv)) {
                return false;
            }
        
            $decryptedData = openssl_decrypt($encryptedData, $this->cryptCipherAlgo, $this->cryptSecretKey, 0, $iv);
        
            return $type === "array" ? unserialize($decryptedData) : $decryptedData;
        }

        private function translatingCrypto($data, $mode) {
            switch ($this->cryptStoreMethod) {
                case "local":
                    return $this->handleFileOperation($data, $mode);
                case "database":
                    return $this->handleDatabaseOperation($data, $mode);
                default:
                    return false;
            }
        }

        private function handleFileOperation($data, $mode) {
            if ($mode === "write") {
                file_put_contents($this->cryptFile, $data . PHP_EOL, FILE_APPEND);
                $this->writeFile($this->cryptLimitLine);
                return true;
            } elseif ($mode === "read") {
                return $this->readFile($data);
            }

            return false;
        }

        private function handleDatabaseOperation($data, $mode) {
            if (!$this->dbhandler) {
                return false;
            }

            return ($mode === "write") ? ($this->dbhandler)($data, "write") : ($this->dbhandler)($data, "read");
        }

        private function writeFile(int $limit): void {
            $fileContent = file($this->cryptFile);

            if (count($fileContent) > $limit) {
                $fileContent = array_slice($fileContent, -$limit);
                file_put_contents($this->cryptFile, implode("", $fileContent));
            }
        }

        private function readFile($data) {
            $fileContent = file($this->cryptFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($fileContent as $line) {
                $part = explode(":", $line);
                if (count($part) === 2 && $part[1] === $data) {
                    return $part[0];
                }
            }

            return false;
        }
    }

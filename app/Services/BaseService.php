<?php

    namespace FW\App\Services;

    class BaseService {

        public Common $common;
        public FileSystem $fileSystem;
        public Cookie $cookie;
        public Session $session;
        public Crypto $crypto;
        public Request $request;
        public Response $response;
        public Validation $validation;

        public function __construct() {
            
            $this->common = new Common();
            $this->fileSystem = new FileSystem();
            $this->cookie = new Cookie();
            $this->session = new Session();
            $this->crypto = new Crypto();
            $this->request = new Request();
            $this->response = new Response();
            $this->validation = new Validation();
            
        }

    }

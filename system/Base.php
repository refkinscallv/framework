<?php

    namespace FW;

    use FW\App\Libraries\Cookie;
    use FW\App\Libraries\Crypto;
    use FW\App\Libraries\Session;
    use FW\Common\Common;
    use FW\Common\FileSystem;
    use FW\Http\Request;
    use FW\Http\Response;
    use FW\Http\Validation;
    use FW\Mailer\Mailer;

    class Base {
        public Common $common;
        public FileSystem $fileSystem;
        public Cookie $cookie;
        public Session $session;
        public Crypto $crypto;
        public Request $request;
        public Response $response;
        public Validation $validation;
        public Mailer $mailer;

        public function __construct(array $except = []) {
            
            $list = [
                "common" => Common::class,
                "fileSystem" => FileSystem::class,
                "cookie" => Cookie::class,
                "session" => Session::class,
                "crypto" => Crypto::class,
                "request" => Request::class,
                "response" => Response::class,
                "validation" => Validation::class,
                "mailer" => Mailer::class,
            ];

            foreach ($list as $property => $class) {
                if (!in_array($property, $except, true)) {
                    $this->{$property} = new $class();
                }
            }

        }
    }

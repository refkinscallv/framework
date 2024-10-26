<?php

    namespace FW\Http\Request;

    use FW\Http\Request\Query;
    use FW\Http\Request\Input;
    use FW\Http\Request\Uri;
    use FW\Http\Request\File;
    use FW\Http\Request\Header;

    class Factory {

        public $query;
        public $input;
        public $uri;
        public $file;
        public $header;

        public function __construct() {
            $this->query = new Query();
            $this->input = new Input();
            $this->uri = new Uri();
            $this->file = new File();
            $this->header = new Header();
        }

    }

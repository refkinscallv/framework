<?php

    /**
     * PHP Framework
     * 
     * A lightweight PHP framework. With traditional concepts including MVC, Query Builder/ORM and Router
     */

    /**
     * checking dependencies
     */
    $dependenciesDir = "vendor/autoload.php";

    if(!file_exists($dependenciesDir)) {
        include "public/views/default.php";
        die();
    }

    /**
     * import boot file
     */
    use FW\Boot;

    require $dependenciesDir;

    /**
     * running the application
     */
    Boot::run();

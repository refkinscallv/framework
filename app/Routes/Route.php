<?php

    use FW\Router\Route;

    Route::register([
        "/module/api"
    ]);
    
    Route::set404(function() {
        echo "Custom Not Found Page";
    });

    Route::get("/", function() {
        echo "Hello World";
    });

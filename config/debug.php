<?php
    return [
        // Possible values 0,1
        'DISPLAY_ERRORS' => env('APP_DEBUG', 1),
        'DISPLAY_STARTUP_ERRORS' => env('DISPLAY_STARTUP_ERRORS', 1),
        // 2 - E_ALL
        // 0 - NONE
        'ERROR_REPORTING' => (env('APP_DEBUG') == true)? E_ALL : -1,
        'DISPLAY_ERRORS' => (env('APP_DEBUG') == true)? 'on' : 'off', 
    ];

?>
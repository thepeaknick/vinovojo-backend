<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| First we need to get an application instance. This creates an instance
| of the application / container and bootstraps the application so it
| is ready to receive HTTP / Console requests from the environment.
|
*/

$app = require __DIR__.'/../bootstrap/app.php';

/**
 * DEBUG LEVEL ## DO NOT CHANGE IT HERE
 * CHANGE IN .env OR config/debug.php
 */
ini_set('display_errors', config('debug.DISPLAY_ERRORS'));
ini_set('display_startup_errors', config('debug.DISPLAY_STARTUP_ERRORS'));
error_reporting(config('debug.ERROR_REPORTING'));
ini_set('display_errors', config('debug.DISPLAY_ERRORS'));

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$app->run();

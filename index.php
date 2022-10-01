<?php

require_once __DIR__;

$app = new Application();

$app->router->get('/', function() {
    return 'oke';
//require_once __DIR__.'/vendor/autoload.php';
//
//$app = new \app\core\Application();
//
//$app->router->get('/', function (){
//    return 'Hello World';
//});
//
//$app->router->get('/contact', function (){
//    return 'Contact';
//});
//
//$app->run();
});

$app->run();
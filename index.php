<?php

require_once __DIR__;

$app = new Application();

$app->router->get('/', function() {
    return "hello world";
});

$app->run();
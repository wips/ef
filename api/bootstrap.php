<?php

error_reporting(E_WARNING | E_ERROR | E_PARSE);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

$app = new Silex\Application();

$app->get('/hello/{name}', function ($name) use ($app) {
    return 'Hello '.$app->escape($name);
});

$app->run();
<?php

error_reporting(E_WARNING | E_ERROR | E_PARSE);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

use \Ef\Application;
use \Ef\Controller\Images;

$silex = new Silex\Application();
$silex['debug'] = true;

$app = new Application($silex, new Images());
$app->start();
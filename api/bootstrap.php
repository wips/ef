<?php

error_reporting(E_WARNING | E_ERROR | E_PARSE);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';

use \Ef\Application;
use \Ef\Controller\Pictures;

$app = new Application(new Silex\Application(), new Pictures());
$app->start();
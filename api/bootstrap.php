<?php

error_reporting(E_WARNING | E_ERROR | E_PARSE);
ini_set('display_errors', 1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../scraping/constants.php';

use \Ef\Application;
use \Ef\Controller\Images;
use \Ef\Storage\File;
use \Ef\Storage\FilterBuilder;
use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;

// dependencies set up
$fsRoot = __DIR__ . '/../scraping';
$silex = new Silex\Application();
$storage = new File(new Filesystem(new LocalAdapter($fsRoot)));
$controller = new Images(new FilterBuilder(), $storage);

$silex['debug'] = true;

$app = new Application($silex, $controller);
$app->start();
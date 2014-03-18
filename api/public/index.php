<?php
error_reporting(E_WARNING | E_ERROR | E_PARSE);
ini_set('display_errors', 1);

$root = dirname(__DIR__);
$loader = require $root . '/../vendor/autoload.php';
$loader->add('', $root . '/classes/');
$loader->add('PHPixie', $root . '/../vendor/phpixie/core/classes/');

$pixie = new \PHPixie\Pixie();

//$pixie->router->add()

$pixie->bootstrap($root)->http_request()->execute()->send_headers()->send_body();
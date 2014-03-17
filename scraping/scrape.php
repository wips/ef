<?php
namespace Ef;
//use Ef\Storage;

require __DIR__ . '/../vendor/autoload.php';
require './constants.php';

$scraper = new Scraper(new Storage\File(), new Flickr());
$scraper->act();
<?php

error_reporting(E_WARNING | E_ERROR | E_PARSE);

use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;

require __DIR__ . '/../vendor/autoload.php';
require 'constants.php';

// dependencies set up
$filesystem = new Filesystem(new LocalAdapter(__DIR__));
$storage = new Ef\Storage\File($filesystem);
$api = new Phlickr_Api(EF_API_KEY, EF_API_SECRET);
$flickr = new Ef\Flickr($api, new Ef\Serializer());
$scraper = new Ef\Scraper($storage, $flickr);

// the job
$scraper->act();
<?php

error_reporting(E_WARNING | E_ERROR | E_PARSE);

use Gaufrette\Filesystem;
use Gaufrette\Adapter\Local as LocalAdapter;
use Ef\Storage\File;
use Ef\Flickr;
use Ef\Scraper;
use Ef\Serializer;

require __DIR__ . '/../vendor/autoload.php';
require 'constants.php';

// dependencies set up
$filesystem = new Filesystem(new LocalAdapter(__DIR__));
$storage = new File($filesystem);
$api = new Phlickr_Api(EF_API_KEY, EF_API_SECRET);
$flickr = new Flickr($api, new Serializer());
$scraper = new Scraper($storage, $flickr);

// the job
$scraper->act();
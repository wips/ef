<?php

phpinfo();
exit;

error_reporting(E_ERROR | E_WARNING | E_PARSE);

require __DIR__ . '/../vendor/autoload.php';

$api = new Phlickr_Api('8a1d1129604827f41d5e97e1ae292f2d', 'a0117cb84153c063');

$request = $api->createRequest(
      'flickr.photos.search',
      array(
          'text' => 'education'
     )
  );
print "Request created.\n";
  $photolist = new Phlickr_PhotoList($request, 10);
print "Photolist created.\n";

$photos = $photolist->getPhotos();

print "Photos taken.\n";

     foreach ($photos as $photo) {
//         print_r($photo);
//             print "Photo: {$photo->getTitle()}\n";
            print ++$i."\n";
             print "{$photo->buildImgUrl(Phlickr_Photo::SIZE_500PX)}\n";
             print "http://farm{$photo->getFarm()}.static.flickr.com/{$photo->getServer()}/{$photo->getId()}_{$photo->getSecret()}.jpg"."\n";
         }

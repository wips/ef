<?php
namespace Ef;

use Phlickr_PhotoList;
use Phlickr_Request;

class Flickr {
    private $api;
    private $serializer;

    public function __construct(\Phlickr_Api $api, Serializer $serializer) {
        $this->api = $api;
        $this->serializer = $serializer;
    }

    public function getPhotos($pageNumber) {
        $request = $this->api->createRequest(
            'flickr.photos.search',
            array('text' => 'education')
        );
        $photoList = $this->createPhotoList($request, EF_IMG_PER_PAGE);
        return $this->serializer->serialize($photoList->getPhotos($pageNumber));
    }

    public function createPhotoList(Phlickr_Request $request, $itemsPerPage) {
        return new Phlickr_PhotoList($request, $itemsPerPage);
    }
}
 
<?php
namespace Ef;

use Phlickr_Photo;

class Serializer {
    public function serialize(array $photos) {
        $serialized = array();
        foreach ($photos as $photo) {
            $sizes = $photo->getSizes();
            $sizes = $sizes['o'];
            $serialized[] = array(
                $sizes[0],
                $sizes[1],
                $photo->getTitle(),
                $photo->getUserId(),
                $this->imgUrl($photo)
            );
        }
        return $serialized;
    }

    protected function imgUrl(\Object $photo) {
        return sprintf(
            "http://farm%d.static.flickr.com/%d/%s_%s.jpg",
            $photo->getFarm(),
            $photo->getServer(),
            $photo->getId(),
            $photo->getSecret()
        );
    }
}
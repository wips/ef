<?php
namespace Ef;
class Serializer {
    public function serialize(array $photos) {
        $serialized = array();
        foreach ($photos as $photo) {
            $sizes = $photo->getSizes();
            $serialized[] = array(
                $sizes['width'],
                $sizes['height'],
                $photo->getTitle(),
                $photo->getUserId(),
                $photo->buildImgUrl()
            );
        }
        return $serialized;
    }
}
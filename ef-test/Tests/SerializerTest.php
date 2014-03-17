<?php
namespace Ef\Tests;
use Ef\Serializer;

class SerializerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers  \Ef\Serializer::serialize
     * @test
     */
    public function serializeFromPhotosToPlainArray()
    {
        $sut = new Serializer();
        $photos = $this->createPhotos(2);

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

        $this->assertEquals($serialized, $sut->serialize($photos));
    }

    private function createPhotos($length) {
        $photos = array();
        for ($i = 0; $i < $length; $i++) {
            $photos[] = $this->createPhoto($i, $i*2, "title$i", "user$i", "url$i");
        }
        return $photos;
    }

    private function createPhoto($width, $height, $title, $userId, $imgUrl) {
        $sizes = array(
            'width' => $width,
            'height' => $height
        );
        $photo = $this->getMockBuilder('Phlickr_Photo')
            ->disableOriginalConstructor()
            ->getMock();
        $photo->expects($this->any())
            ->method('getSizes')
            ->will($this->returnValue($sizes));
        $photo->expects($this->any())
            ->method('getTitle')
            ->will($this->returnValue($title));
        $photo->expects($this->any())
            ->method('getUserId')
            ->will($this->returnValue($userId));
        $photo->expects($this->any())
            ->method('buildImgUrl')
            ->will($this->returnValue($imgUrl));
        return $photo;
    }
}
 
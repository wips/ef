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
            $sizes = $sizes[\Phlickr_Photo::SIZE_ORIGINAL];
            $url = sprintf(
                "http://farm%d.static.flickr.com/%d/%s_%s.jpg",
                $photo->getFarm(),
                $photo->getServer(),
                $photo->getId(),
                $photo->getSecret()
            );
            $serialized[] = array(
                $sizes[0],
                $sizes[1],
                $photo->getTitle(),
                $photo->getUserId(),
                $url
            );
        }

        $this->assertEquals($serialized, $sut->serialize($photos));
    }

    private function createPhotos($length) {
        $photos = array();
        for ($i = 0; $i < $length; $i++) {
            $photos[] = $this->createPhoto(
                $i,
                $i*2,
                "title$i",
                "user$i",
                "farm$i",
                "server$i",
                "id$i",
                "secret$i"
            );
        }
        return $photos;
    }

    private function createPhoto($width, $height, $title, $userId, $farm, $server, $id, $secret) {
        $sizes = array(
            \Phlickr_Photo::SIZE_ORIGINAL => array($width, $height)
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
            ->method('getFarm')
            ->will($this->returnValue($farm));
        $photo->expects($this->any())
            ->method('getServer')
            ->will($this->returnValue($server));
        $photo->expects($this->any())
            ->method('getId')
            ->will($this->returnValue($id));
        $photo->expects($this->any())
            ->method('getSecret')
            ->will($this->returnValue($secret));
        return $photo;
    }
}
 
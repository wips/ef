<?php
namespace Ef\Tests;

class FlickrTest extends \PHPUnit_Framework_TestCase {

    private $request;
    private $api;
    private $serializer;

    public function setUp() {
        $this->request = $this->getMockBuilder('Phlickr_Request')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->api = $this->getMock('Phlickr_Api', array('createRequest'), array(1, 1));
        $this->api->expects($this->once())
                  ->method('createRequest')
                  ->with('flickr.photos.search', array('text' => 'education'))
                  ->will($this->returnValue($this->request));

        $this->serializer = $this->getMock('Ef\Serializer', array('serialize'));
    }

    /**
     * @covers  \Ef\Flickr::getPhotos
     * @test
     */
    public function createPhotosArrayBasedOnPhotoList()
    {
        $photos = array('some array with Phlickr_Photo objects');
        $pageNumber = 3;

        $photoList = $this->getMockBuilder('Phlickr_PhotoList', array('getPhotos'))
                          ->disableOriginalConstructor()
                          ->getMock();
        $photoList->expects($this->once())
                  ->method('getPhotos')
                  ->with($pageNumber)
                  ->will($this->returnValue($photos));

        $this->serializer->expects($this->once())
            ->method('serialize')
            ->will($this->returnValue($photos));

        $sut = $this->getMock('Ef\Flickr', array('createPhotoList'), array($this->api, $this->serializer));
        $sut->expects($this->once())
            ->method('createPhotoList')
            ->with($this->request, EF_IMG_PER_PAGE)
            ->will($this->returnValue($photoList));

        $this->assertEquals($photos, $sut->getPhotos($pageNumber));
    }
}
 
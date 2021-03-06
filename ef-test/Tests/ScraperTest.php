<?php
namespace Ef\Tests;
use Ef\Scraper;

class ScraperTest extends \PHPUnit_Framework_TestCase {

    /**
     * @covers  \Ef\Scraper::act
     * @test
     */
    public function passPhotosToStorage()
    {
        $photos = array('some photos from API');
        $lastSavedPageNumber = 'some page number';

        $storage = $this->getMock('Ef\Storage', array('save', 'getSavedPagesNumber', 'items'));
        $storage->expects($this->once())
                ->method('save')
                ->with($photos);
        $storage->expects($this->once())
                ->method('getSavedPagesNumber')
                ->will($this->returnValue($lastSavedPageNumber));

        $flickr = $this->getMockBuilder('Ef\Flickr', array('getPhotos'))
                       ->disableOriginalConstructor()
                       ->getMock();

        $flickr->expects($this->once())
               ->method('getPhotos')
               ->with($lastSavedPageNumber)
               ->will($this->returnValue($photos));

        $sut = new Scraper($storage, $flickr);
        $sut->act();
    }
}
 
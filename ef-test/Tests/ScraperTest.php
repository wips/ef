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
        $photos = array('some photos from APIx');
        $lastSavedPageNumber = 'some page number';

        $storage = $this->getMock('Ef\Storage', array('save', 'getLastSavedPage'));
        $storage->expects($this->once())
                ->method('save')
                ->with($photos);
        $storage->expects($this->once())
                ->method('getLastSavedPage')
                ->will($this->returnValue($lastSavedPageNumber));

        $flickr = $this->getMock('Ef\Flickr', array('getPhotos'));
        $flickr->expects($this->once())
               ->method('getPhotos')
               ->with($lastSavedPageNumber)
               ->will($this->returnValue($photos));

        $sut = new Scraper($storage, $flickr);
        $sut->act();
    }
}
 
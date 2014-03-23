<?php
namespace Ef\Tests\Storage;
use \Ef\Storage\File;

class FileTest extends \PHPUnit_Framework_TestCase {
    private $fs;
    private $pages = 2;
    private $dataFromFile;
    private $sut;

    public function setUp() {
        $this->dataFromFile = $this->createSerializedData($this->pages);
        $this->fs = $this->getMockBuilder('Gaufrette\Filesystem', array('read'))
            ->disableOriginalConstructor()
            ->getMock();
        $this->sut = new File($this->fs);
    }

    /**
     * @dataProvider itemsProvider
     * @covers  \Ef\Storage\File::items
     * @test
     */
    public function items($filter) {
        $this->fs->expects($this->once())
            ->method('read')
            ->with(EF_STORE_FILE)
            ->will($this->returnValue($this->dataFromFile));
        $expected = $this->filtrationLogicEncapsulatedHere($filter);
        $this->assertEquals($expected, $this->sut->items($filter));
    }

    function itemsProvider() {
        return array(
            array($this->anEmptyFilter()), // an empty filter that should match all
            array($this->aFilterThatMatchesNothing()),
            array($this->aFilterThatMatchesSomeAttributesButNoPictures()),
            array($this->aFilterThatMatchesOnePictureByAllParams()),
            array($this->aFilterThatMatchesOnePictureByOneParameter())
        );
    }

    private function filtrationLogicEncapsulatedHere($filter) {
        $pictures = unserialize($this->dataFromFile);
        $filtered = array_filter($pictures, function ($picture) use ($filter) {
            for ($i = 0; $i < sizeof($picture); $i++) {
                if ($filter[$i] !== null && $picture[$i] != $filter[$i]) {
                    return false;
                }
            }
            return true;
        });
        return array_values($filtered);
    }

    /**
     * @covers  \Ef\Storage\File::getSavedPagesNumber
     * @test
     */
    public function countSavedPages()
    {
        $this->fs->expects($this->once())
            ->method('read')
            ->with(EF_STORE_FILE)
            ->will($this->returnValue($this->dataFromFile));

        $this->assertEquals($this->pages, $this->sut->getSavedPagesNumber());
    }

    /**
     * @covers  \Ef\Storage\File::save
     * @test
     */
    public function savePhotos() {
        $dataToSave = $this->createData(1);

        $serialized = serialize(array_merge(unserialize($this->dataFromFile), $dataToSave));

        $this->fs->expects($this->once())
            ->method('read')
            ->with(EF_STORE_FILE)
            ->will($this->returnValue($this->dataFromFile));
        $this->fs->expects($this->once())
            ->method('write')
            ->with(EF_STORE_FILE, $serialized, true);


        $this->sut->save($dataToSave);
    }

    /**
     * @covers  \Ef\Storage\File::save
     * @test
     */
    public function savePhotosInEmptyFile() {
        $dataToSave = $this->createData(1);

        $this->fs->expects($this->once())
            ->method('read')
            ->with(EF_STORE_FILE)
            ->will($this->returnValue(''));

        $this->fs->expects($this->once())
            ->method('write')
            ->with(EF_STORE_FILE, serialize($dataToSave), true);

        $this->sut->save($dataToSave);
    }

    private function getTotalImages() {
        return $this->pages * EF_IMG_PER_PAGE;
    }

    private function createSerializedData() {
        return serialize($this->createData());
    }

    private function createData() {
        $data = array();
        for ($i = 0; $i < $this->getTotalImages(); $i++) {
            $data[] = $this->createPicture($i);
        }
        return $data;
    }

    private function createPicture($index) {
        return array(
            $index,
            $index * 2,
            "Title #$index",
            "User #" . ($index % 3), // some pictures should have equal params to test filter
            "Url #$index"
        );
    }

    private function aFilterThatMatchesNothing() {
        return array($this->getTotalImages() + 1, null, null, null, null);
    }

    private function aFilterThatMatchesSomeAttributesButNoPictures() {
        return array(
            $this->getTotalImages() - 1, // matches first picture
            'any height that matches nothing',
            null,
            null,
            null
        );
    }

    private function aFilterThatMatchesOnePictureByAllParams() {
        return $this->createPicture($this->getTotalImages() - 1);
    }

    private function aFilterThatMatchesOnePictureByOneParameter() {
        return array(0, null, null, null, null);
    }

    private function anEmptyFilter() {
        return array(null, null, null, null, null);
    }
}
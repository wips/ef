<?php
namespace Ef\Tests\Storage;
use \Ef\Storage\File;

class FileTest extends \PHPUnit_Framework_TestCase {
    private $fs;
    private $pages = 2;
    private $dataFromFile;

    public function setUp() {
        $this->dataFromFile = $this->createSerializedData($this->pages);
        $this->fs = $this->getMockBuilder('Gaufrette\Filesystem', array('read'))
            ->disableOriginalConstructor()
            ->getMock();
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

        $sut = new File($this->fs);
        $this->assertEquals($this->pages, $sut->getSavedPagesNumber());
    }

    /**
     * @covers  \Ef\Storage\File::save
     * @test
     */
    public function savePhotos() {
        $sut = new File($this->fs);
        $dataToSave = $this->createData(1);

        $serialized = serialize(array_merge(unserialize($this->dataFromFile), $dataToSave));

        $this->fs->expects($this->once())
            ->method('write')
            ->with(EF_STORE_FILE, $serialized, true);
        $this->fs->expects($this->once())
            ->method('read')
            ->with(EF_STORE_FILE)
            ->will($this->returnValue($this->dataFromFile));

        $sut->save($dataToSave);
    }

    /**
     * @covers  \Ef\Storage\File::save
     * @test
     */
    public function savePhotosInEmptyFile() {
        $sut = new File($this->fs);
        $dataToSave = $this->createData(1);

        $this->fs->expects($this->once())
            ->method('read')
            ->with(EF_STORE_FILE)
            ->will($this->returnValue(''));

        $this->fs->expects($this->once())
            ->method('write')
            ->with(EF_STORE_FILE, serialize($dataToSave), true);

        $sut->save($dataToSave);
    }

    private function createSerializedData($pages) {
        return serialize($this->createData($pages));
    }

    private function createData($pages) {
        $data = array();
        for ($i = 0; $i < $pages * EF_IMG_PER_PAGE; $i++) {
            $data[] = "some data $i";
        }
        return $data;
    }
}
 
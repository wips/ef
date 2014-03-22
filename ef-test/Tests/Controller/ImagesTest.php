<?php
namespace Ef\Tests\Controller;

use Ef\Controller\Images;

class VisualsTest extends \PHPUnit_Framework_TestCase {
    /**
     * @covers \Ef\Controller\Images::all
     * @test1
     */
    public function all() {
        $filterParameters = array('any' => 'filter parameters');
        $images = array();
        $request = $this->getMock('Symfony\Component\HttpFoundation\Request');

        $filterBuilder = $this->getMock('\Ef\Storage\FilterBuilder', array('build'));
        $filterBuilder->expects($this->once())
            ->method('build')
            ->with($request)
            ->will($this->returnValue($filterParameters));

        $storage = $this->getMockForAbstractClass('\Ef\Storage');

        $sut = new Images($filterBuilder, $storage);

        $storage->expects($this->once())
            ->method('items')
            ->with($filterParameters)
            ->will($this->returnValue($images));

        $this->assertEquals($images, $sut->all($request));
    }
}
 
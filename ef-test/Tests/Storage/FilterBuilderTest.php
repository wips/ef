<?php
namespace Ef\Tests\Storage;

use Ef\Storage\FilterBuilder;

class FilterBuilderTest extends \PHPUnit_Framework_TestCase {
    /**
     * @covers Ef\Storage\FilterBuilder::build
     * @test
     */
    public function build() {
        list($width, $height, $title, $user, $url) = array(1, 2, 'title', 'user', 'url');
        $request = $this->getMock('Symfony\Component\HttpFoundation\Request', array('get'));

        $request->expects($this->any())
            ->method('get')
            ->will($this->returnCallback(function ($parameter) use ($width, $height, $title, $user, $url) {
                switch ($parameter) {
                    case 'width':
                        return $width;
                        break;
                    case 'height':
                        return $height;
                        break;
                    case 'title':
                        return $title;
                        break;
                    case 'user':
                        return $user;
                        break;
                    case 'url':
                        return $url;
                }
            }));

        $filterParams = array($width, $height, $title, $user, $url);

        $sut = new FilterBuilder();

        $this->assertSame($filterParams, $sut->build($request));
    }
}
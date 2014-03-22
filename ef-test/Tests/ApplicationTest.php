<?php
namespace Ef\Tests;
use \Ef\Application;

class ApplicationTest extends \PHPUnit_Framework_TestCase {
    private $app;
    private $controller;
    private $sut;

    public function setUp() {
        $this->app = $this->getMockBuilder('Silex\Application', array('run', 'get', 'json'))
            ->disableOriginalConstructor()
            ->getMock();
        $this->controller = $this->getMock('\Ef\Controller\Pictures', array('all'));
        $this->sut = new Application($this->app, $this->controller);
    }

    /**
     * @covers \Ef\Application::start
     * @test
     */
    public function runsApplication() {
        $this->app->expects($this->once())
            ->method('run');
        $this->sut->start();
    }

    /**
     * @covers \Ef\Application::start
     * @test
     */
    public function handlesGetForImages() {
        $result = array();
        $json = 'string';

        $this->controller->expects($this->once())
            ->method('all')
            ->will($this->returnValue($result));

        $self = $this;
        $this->app->expects($this->once())
            ->method('get')
            ->with('/images/{title}/{user}/{url}/{width}/{height}')
            ->will($this->returnCallback(function ($route, $callback) use ($self, $json) {
                $handlerResult = $callback();
                $self->assertEquals($handlerResult, $json);
            }));

        $this->app->expects($this->once())
            ->method('json')
            ->with($result)
            ->will($this->returnValue($json));

        $this->sut->start();
    }
}
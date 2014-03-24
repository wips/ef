<?php
namespace Ef;

use Symfony\Component\HttpFoundation\Request;

class Application {
    private $app;
    private $controller;

    public function __construct(\Silex\Application $app, $controller) {
        $this->app = $app;
        $this->controller = $controller;
    }

    public function start() {
        $controller = $this->controller;
        $app = $this->app;
        $this->app->post('/', function (Request $request) use ($controller, $app) {
            return $app->json(
                $controller->all($request),
                200,
                array('Access-Control-Allow-Origin' => '*')
            );
        });
        $this->app->run();
    }
}

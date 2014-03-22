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
        $this->app->get('/images', function (Request $request) use ($controller, $app) {
            return $app->json($controller->all($request));
        });
        $this->app->run();
    }
}

<?php
namespace Ef;

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
        $this->app->get('/images/{title}/{user}/{url}/{width}/{height}', function () use ($controller, $app) {
            return $app->json($controller->all());
        });
        $this->app->run();
    }
}

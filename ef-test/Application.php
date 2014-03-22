<?php
namespace Ef;

class Application {
    private $app;
    private $controller;

    public function __construct($app, $controller) {
        $this->app = $app;
        $this->controller = $controller;
    }

    public function start() {
        $controller = $this->controller;
        $app = $this->app;
        $this->app->get('/images/id/{id}', function () use ($controller, $app) {
            return $app->json($controller->all());
        });
        $this->app->run();
    }
}
 
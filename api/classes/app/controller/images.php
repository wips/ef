<?php
namespace PHPixie\Controller;

class Images extends Page {

    public function action_index() {
        $this->response->body = 'images';
    }
}
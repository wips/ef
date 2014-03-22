<?php
namespace Ef\Controller;

use Ef\Storage\FilterBuilder;
use Ef\Storage;
use Symfony\Component\HttpFoundation\Request;

class Images extends AbstractController {
    private $filterBuilder;
    private $storage;
    public function __construct(FilterBuilder $filterBuilder, Storage $storage) {
        $this->filterBuilder = $filterBuilder;
        $this->storage = $storage;
    }
    public function all(Request $request) {
        return $this->storage->items($this->filterBuilder->build($request));
    }
}
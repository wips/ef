<?php
namespace Ef;

abstract class Storage {
    abstract public function save(array $data);
    abstract public function getSavedPagesNumber();
}
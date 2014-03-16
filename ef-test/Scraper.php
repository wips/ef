<?php
    namespace Ef;

    class Scraper {

        protected $storage;

        function __construct(Storage $storage, Flickr $flickr) {
            $this->storage = $storage;
            $this->flickr = $flickr;
        }

        public function act() {
            $this->storage->save($this->flickr->getPhotos($this->storage->getLastSavedPage()));
        }
    }
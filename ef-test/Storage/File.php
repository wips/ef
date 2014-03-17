<?php
namespace Ef\Storage;
use Gaufrette\Filesystem;

class File extends \Ef\Storage {
    private $fs;

    function __construct(Filesystem $fs) {
        $this->fs = $fs;
    }

    function getSavedPagesNumber() {
        $content = $this->fs->read(EF_STORE_FILE);
        return sizeof(unserialize($content)) / EF_IMG_PER_PAGE;
    }

    function save(array $data) {
        $serialized = array_merge(
            unserialize($this->fs->read(EF_STORE_FILE)),
            $data
        );
        $this->fs->write(EF_STORE_FILE, $serialized);
    }
}
 
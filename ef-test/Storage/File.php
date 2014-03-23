<?php
namespace Ef\Storage {
    use Ef\Storage;
    use Gaufrette\Filesystem;

    class File extends Storage {
        private $fs;

        function __construct(Filesystem $fs) {
            $this->fs = $fs;
        }

        function getSavedPagesNumber() {
            return sizeof($this->getAll()) / EF_IMG_PER_PAGE;
        }

        function save(array $data) {
            $contents = $this->fs->read(EF_STORE_FILE);

            if ($contents == '') {
                $toSave = $data;
            } else {
                $toSave = array_merge(unserialize($contents), $data);
            }

            $this->fs->write(EF_STORE_FILE, serialize($toSave), true);
        }

        function items(array $filter) {
            $filtered = array_filter($this->getAll(), function ($picture) use ($filter) {
                for ($i = 0; $i < sizeof($picture); $i++) {
                    if ($filter[$i] !== null && $picture[$i] != $filter[$i]) {
                        return false;
                    }
                }
                return true;
            });
            return array_values($filtered);
        }

        private function getAll() {
            return unserialize($this->fs->read(EF_STORE_FILE));
        }
    }
}

<?php

namespace Drinks\Services;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;

class FileHandler {

    private $fileLocation;

    private $fileHandle;

    public function __construct($fileLocation) {
        $this->fileLocation = $fileLocation;
        $this->fileHandle = fopen(realpath($fileLocation), "r");
        if (!is_resource($this->fileHandle)) {
            throw new FileNotFoundException('File could not be opened at location: ' . $fileLocation);
        }
    }

    public function getNextLine() {
        return fgets($this->getFileHandle());
    }

    public function closeFile() {
        return fclose($this->getFileHandle());
    }

    private function getFileHandle() {
        return $this->fileHandle;
    }
}
<?php

namespace Calendar\Services;

class FileLoader {

    /*
     * Basic wrapper so I can mock out loading a JSON file
     */
    public function loadFile($fileLocation)
    {
        return file_get_contents(realpath($fileLocation));
    }
}
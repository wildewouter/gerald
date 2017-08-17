<?php

namespace Document\Domain;

use Symfony\Component\HttpFoundation\File\File;

interface DocumentFileStorage
{
    public function store(FileData $fileData, File $file);

    /**
     * @param string $fileName
     * @return resource
     */
    public function get(string $fileName);
}

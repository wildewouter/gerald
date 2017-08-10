<?php

namespace Document\Domain;

use Symfony\Component\HttpFoundation\File\File;

interface DocumentFileStorage
{
    public function store(FileData $fileData, File $file);

    public function get(FileId $fileId): FileData;
}

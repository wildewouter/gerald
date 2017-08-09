<?php

namespace Document\Domain;

interface DocumentFileStorage
{
    public function store(File $file);

    public function get(FileId $fileId): File;
}

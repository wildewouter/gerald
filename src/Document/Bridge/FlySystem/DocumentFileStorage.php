<?php

namespace Document\Bridge\FlySystem;

use Document\Domain\DocumentFileStorage as DomainFileStorage;
use Document\Domain\File;
use Document\Domain\FileId;
use League\Flysystem\Filesystem;

final class DocumentFileStorage implements DomainFileStorage
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function store(File $file)
    {
        $stream = fopen($file->data()->getRealPath(), 'r+');
        $this->filesystem->writeStream($file->id(), $stream);
        fclose($stream);
    }

    public function get(FileId $fileId): File
    {
//        return $this->filesystem->readStream($fileId);
    }
}

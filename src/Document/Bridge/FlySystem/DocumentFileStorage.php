<?php

namespace Document\Bridge\FlySystem;

use Document\Domain\DocumentFileStorage as DomainFileStorage;
use Document\Domain\FileData;
use League\Flysystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;

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

    public function store(FileData $fileData, File $file)
    {
        $stream = fopen($file->getRealPath(), 'r+');
        $this->filesystem->writeStream($fileData->getFileName(), $stream);
        fclose($stream);
    }

    public function get(string $fileName)
    {
        return $this->filesystem->readStream($fileName);
    }
}

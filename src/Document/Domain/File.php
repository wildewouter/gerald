<?php

namespace Document\Domain;

use Symfony\Component\HttpFoundation\File\File as SymfonyFile;

final class File implements Storable
{
    /**
     * @var FileId
     */
    private $id;

    /**
     * @var SymfonyFile
     */
    private $file;

    public function __construct(FileId $id, SymfonyFile $file)
    {
        $this->id   = $id;
        $this->file = $file;
    }

    public function id(): FileId
    {
        return $this->id;
    }

    public function data(): SymfonyFile
    {
        return $this->file;
    }

    public function toArray(): array
    {
        return ['file_name' => $this->id];
    }
}

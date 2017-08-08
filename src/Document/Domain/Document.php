<?php

namespace Document\Domain;

final class Document
{
    /**
     * @var DocumentId
     */
    private $id;

    /**
     * @var File
     */
    private $file;

    /**
     * @var array
     */
    private $meta;

    public function __construct(DocumentId $id, File $file, array $meta)
    {
        $this->id   = $id;
        $this->file = $file;
        $this->meta = $meta;
    }
}

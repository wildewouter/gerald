<?php

namespace Document\Domain;

final class Document implements Storable
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

    public function id(): DocumentId
    {
        return $this->id;
    }

    public function file(): File
    {
        return $this->file;
    }

    public function meta(): array
    {
        return $this->meta;
    }

    public function toArray(): array
    {
        return [
            'id'       => (string) $this->id,
            'meta'     => $this->meta,
            'fileName' => (string) $this->file->id(),
        ];
    }
}

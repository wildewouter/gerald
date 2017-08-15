<?php

namespace Document\Domain;

final class Document implements Storable
{
    /**
     * @var DocumentId
     */
    private $id;

    /**
     * @var FileData
     */
    private $fileData;

    /**
     * @var array
     */
    private $meta;

    public function __construct(DocumentId $id, FileData $fileData, array $meta)
    {
        $this->id       = $id;
        $this->fileData = $fileData;
        $this->meta     = $meta;
    }

    public function id(): DocumentId
    {
        return $this->id;
    }

    public function fileData(): FileData
    {
        return $this->fileData;
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
            'fileData' => $this->fileData->toArray(),
        ];
    }

    public function equals(Document $document): bool
    {
        return $document->toArray() === $this->toArray();
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }
}

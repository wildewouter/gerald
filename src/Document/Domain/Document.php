<?php

namespace Document\Domain;

use DateTimeImmutable;

final class Document
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

    /**
     * @var DateTimeImmutable
     */
    private $createdDate;
    /**
     * @var DateTimeImmutable
     */
    private $updatedDate;

    /**
     * @var DateTimeImmutable
     */
    private $deletedDate;

    public function __construct(
        DocumentId $id,
        FileData $fileData,
        array $meta,
        DateTimeImmutable $createdDate,
        DateTimeImmutable $updatedDate = null,
        DateTimeImmutable $deletedDate = null
    ) {
        $this->id          = $id;
        $this->fileData    = $fileData;
        $this->meta        = $meta;
        $this->createdDate = $createdDate;
        $this->updatedDate = $updatedDate;
        $this->deletedDate = $deletedDate;
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

    public function createdDate(): DateTimeImmutable
    {
        return $this->createdDate;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function updatedDate()
    {
        return $this->updatedDate;
    }

    /**
     * @return DateTimeImmutable|null
     */
    public function deletedDate()
    {
        return $this->deletedDate;
    }

    public function equals(Document $document): bool
    {
        return $document->toArray() === $this->toArray();
    }

    public function toArray(): array
    {
        $documentArray = [
            'id'       => (string) $this->id,
            'meta'     => $this->meta,
            'fileData' => $this->fileData->toArray(),
            'created'  => $this->createdDate->format('Y-m-d H:i:s')
        ];

        if ($this->updatedDate) {
            $documentArray['updated'] = $this->updatedDate->format('Y-m-d H:i:s');
        }

        if ($this->deletedDate) {
            $documentArray['deleted'] = $this->deletedDate->format('Y-m-d H:i:s');
        }

        return $documentArray;
    }

    public function __toString()
    {
        return json_encode($this->toArray());
    }
}

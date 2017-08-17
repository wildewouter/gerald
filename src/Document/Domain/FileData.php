<?php

namespace Document\Domain;

final class FileData implements Storable
{
    /**
     * @var FileId
     */
    private $id;

    /**
     * @var string
     */
    private $mimeType;

    /**
     * @var string
     */
    private $extension;

    public function __construct(FileId $id, string $mimeType, string $extension)
    {
        $this->id        = $id;
        $this->mimeType  = $mimeType;
        $this->extension = $extension;
    }

    public function id(): FileId
    {
        return $this->id;
    }

    public function toArray(): array
    {
        return [
            'id'         => (string) $this->id,
            'name'       => $this->getFileName(),
            'mime_type'  => $this->mimeType,
            'extension' => $this->extension,
        ];
    }

    public function getFileName()
    {
        return $this->id . '.' . $this->extension;
    }

    public function mimeType()
    {
        return $this->mimeType;
    }
}

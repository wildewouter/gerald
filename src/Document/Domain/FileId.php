<?php

namespace Document\Domain;

use Ramsey\Uuid\Uuid;

final class FileId
{
    /**
     * @var string
     */
    private $id;

    private function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function createNew(): FileId
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString(string $id): FileId
    {
        return new self($id);
    }

    public function __toString()
    {
        return $this->id;
    }
}

<?php

namespace Document\Domain;

use Traversable;

final class Documents implements \IteratorAggregate
{
    /**
     * @var Document[]
     */
    private $documents;

    private function __construct(array $documents)
    {
        $this->documents = $documents;
    }

    public static function empty(): Documents
    {
        return new self([]);
    }

    public static function fromArray(array $documents): Documents
    {
        return new self($documents);
    }

    public function add(Document $document): Documents
    {
        return new self(array_merge($this->documents, [$document]));
    }

    public function toArray(): array
    {
        $documentArray = [];

        foreach ($this->documents as $document) {
            $documentArray[] = $document->toArray();
        }

        return $documentArray;
    }

    public function first(): Document
    {
        return reset($this->documents);
    }

    /**
     * Retrieve an external iterator
     * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->documents);
    }
}

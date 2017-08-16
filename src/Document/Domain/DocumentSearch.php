<?php

namespace Document\Domain;

use Document\Bridge\Gerald\Flattener;
use InvalidArgumentException;
use Traversable;

final class DocumentSearch implements \IteratorAggregate
{
    /** @var DocumentSearchQuery[] */
    private $queries;

    /**
     * @param DocumentSearchQuery[] $documentSearchQueries
     */
    private function __construct(array $documentSearchQueries)
    {
        foreach ($documentSearchQueries as $documentSearchQuery) {
            $this->validateQuery($documentSearchQuery);
        }

        $this->queries = $documentSearchQueries;
    }

    public static function empty(): DocumentSearch
    {
        return new self([]);
    }

    public static function fromArray(array $queries): DocumentSearch
    {
        return new self($queries);
    }

    public function flattenedMetaSearch(): array
    {
        $searchArray = [];

        /** @var DocumentSearchQuery $query */
        foreach ($this as $query) {
            $searchArray = array_merge($searchArray, $query->toArray());
        }

        $metaArray = ['meta' => $searchArray];
        Flattener::flatten($metaArray);

        return $metaArray;
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
        return new \ArrayIterator($this->queries);
    }

    /**
     * @param $documentSearchQuery
     *
     * @throws InvalidArgumentException
     */
    private function validateQuery($documentSearchQuery)
    {
        if (! $documentSearchQuery instanceof DocumentSearchQuery) {
            throw new InvalidArgumentException(
                get_class($documentSearchQuery) . ' should be ' . DocumentSearchQuery::class);
        }
    }
}

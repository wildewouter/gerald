<?php

namespace Tests\Unit\Document\Domain;

use Document\Domain\DocumentSearch;
use Document\Domain\DocumentSearchQuery;
use PHPUnit\Framework\TestCase;

class DocumentSearchTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testOnlySearchQueriesAreAccepted()
    {
        $queries = [new \stdClass()];

        DocumentSearch::fromArray($queries);
    }

    public function testDocumentSearchFlattening()
    {
        $queries = [new DocumentSearchQuery('name', 'jon snow')];

        $documentSearch = DocumentSearch::fromArray($queries);

        $expected = ['meta.name' => 'jon snow'];

        $this->assertEquals($expected, $documentSearch->flattenedMetaSearch());
    }
}

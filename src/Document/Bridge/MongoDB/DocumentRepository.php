<?php

namespace Document\Bridge\MongoDB;

use Document\Domain\Document;
use Document\Domain\DocumentFileStorage;
use Document\Domain\DocumentId;
use Document\Domain\DocumentRepository as DomainRepository;
use Document\Domain\DocumentStorageFailedException;
use MongoDB\Collection;
use MongoDB\Database;

final class DocumentRepository implements DomainRepository
{
    /**
     * @var Collection
     */
    private $documentCollection;

    /**
     * @var DocumentFileStorage
     */
    private $documentFileStorage;

    public function __construct(Database $database, DocumentFileStorage $documentFileStorage)
    {
        $this->documentCollection  = $database
            ->selectCollection('documents');
        $this->documentFileStorage = $documentFileStorage;
    }

    /**
     * @return Document[]
     */
    public function getAllDocuments(): array
    {

    }

    public function getDocumentsForId(DocumentId $id): Document
    {

    }

    public function save(Document $document = null): Document
    {
        $result = $this->documentCollection->insertOne($document->toArray());

        if (! $result->isAcknowledged()) {
            throw new DocumentStorageFailedException();
        }

        return $document;
    }
}

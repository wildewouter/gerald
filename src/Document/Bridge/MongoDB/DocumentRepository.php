<?php

namespace Document\Bridge\MongoDB;

use Document\Domain\Document;
use Document\Domain\DocumentId;
use Document\Domain\DocumentRepository as DomainRepository;
use MongoDB\Client;

final class DocumentRepository implements DomainRepository
{
    private $documentCollection;

    public function __construct(Client $client)
    {
        $this->documentCollection = $client
            ->selectDatabase('kifid')
            ->selectCollection('documents');
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

    public function save(Document $document = null): DocumentId
    {
        dump($this->documentCollection->find()->toArray());die;
        dump($this->documentCollection->insertOne(['data' => ['somedata']]));
        die;
    }
}

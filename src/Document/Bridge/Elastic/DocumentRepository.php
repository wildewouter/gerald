<?php

namespace Document\Bridge\Elastic;

use Document\Domain\Document;
use Document\Domain\DocumentId;
use Document\Domain\DocumentRepository as DomainRepository;

final class DocumentRepository implements DomainRepository
{
    /**
     * @return Document[]
     */
    public function getAllDocuments(): array
    {
        // TODO: Implement getAllDocuments() method.
    }

    public function getDocumentsForId(DocumentId $id): Document
    {
        // TODO: Implement getDocumentsForId() method.
    }

    public function save(Document $document): Document
    {
        // TODO: Implement save() method.
    }
}

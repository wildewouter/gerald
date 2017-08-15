<?php

namespace Document\Bridge\Elastic;

use Document\Domain\Document;
use Document\Domain\DocumentId;
use Document\Domain\DocumentRepository as DomainRepository;
use Document\Domain\Documents;
use Document\Domain\DocumentSearch;

final class DocumentRepository implements DomainRepository
{
    /**
     * @return Documents
     */
    public function findAll(): Documents
    {
        // TODO: Implement getAllDocuments() method.
    }

    public function findById(DocumentId $id): Document
    {
        // TODO: Implement getDocumentsForId() method.
    }

    public function save(Document $document): Document
    {
        // TODO: Implement save() method.
    }

    public function delete(DocumentId $id)
    {
        // TODO: Implement delete() method.
    }

    public function search(DocumentSearch $search): Documents
    {
        // TODO: Implement search() method.
    }
}

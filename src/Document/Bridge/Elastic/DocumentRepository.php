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

    public function search(DocumentSearch $search, int $offset = 0, int $limit = 100, string $sort = null, string $order = 'asc'): Documents
    {
        // TODO: Implement search() method.
    }

    public function findByFileName(string $fileName): Document
    {
        // TODO: Implement findByFileName() method.
    }
}

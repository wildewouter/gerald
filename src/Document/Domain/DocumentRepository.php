<?php

namespace Document\Domain;

interface DocumentRepository
{
    /**
     * @return Document[]
     */
    public function getAllDocuments(): array;

    public function getDocumentsForId(DocumentId $id): Document;

    public function save(Document $document): bool;
}

<?php

namespace Document\Domain;

interface DocumentRepository
{
    /**
     * @return Documents
     */
    public function getAllDocuments(): Documents;

    public function getDocumentsForId(DocumentId $id): Document;

    public function save(Document $document): Document;
}

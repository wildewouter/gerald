<?php

namespace Document\Domain;

interface DocumentRepository
{
    /**
     * @return Documents
     */
    public function findAll(): Documents;

    public function findById(DocumentId $id): Document;

    public function save(Document $document): Document;

    public function delete(DocumentId $id);

    public function search(DocumentSearch $search): Documents;
}

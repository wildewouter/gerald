<?php

namespace Document\Domain;

interface DocumentRepository
{
    /**
     * @return Documents
     */
    public function findAll(): Documents;

    /**
     * @param DocumentId $id
     * @return Document
     *
     * @throws DocumentNotFoundException
     */
    public function findById(DocumentId $id): Document;

    /**
     * @param string $fileName
     * @return Document
     *
     * @throws DocumentNotFoundException
     */
    public function findByFileName(string $fileName): Document;

    public function save(Document $document): Document;

    public function delete(DocumentId $id);

    public function search(DocumentSearch $search, int $offset = 0, int $limit = 100, string $sort = null, string $order = 'asc'): Documents;
}

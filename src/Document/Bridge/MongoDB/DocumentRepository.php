<?php

namespace Document\Bridge\MongoDB;

use Document\Bridge\Gerald\Flattener;
use Document\Domain\Document;
use Document\Domain\DocumentFileStorage;
use Document\Domain\DocumentId;
use Document\Domain\DocumentRepository as DomainRepository;
use Document\Domain\Documents;
use Document\Domain\DocumentSearch;
use Document\Domain\DocumentStorageFailedException;
use Document\Domain\FileData;
use Document\Domain\FileId;
use MongoDB\Collection;
use MongoDB\Database;
use MongoDB\Model\BSONDocument;

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
     * @return Documents
     */
    public function findAll(): Documents
    {
        return $this->mapMongoDocumentsToDocuments($this->documentCollection->find());
    }

    public function findById(DocumentId $id): Document
    {
        $documents = $this->mapMongoDocumentsToDocuments($this->documentCollection->find(['id' => (string) $id]));

        return $documents->first();
    }

    public function save(Document $document): Document
    {
        $result = $this->documentCollection->insertOne($document->toArray());

        if (! $result->isAcknowledged()) {
            throw new DocumentStorageFailedException();
        }

        return $document;
    }

    public function delete(DocumentId $id)
    {
        // TODO: Implement delete() method.
    }

    public function search(DocumentSearch $search, int $offset = 0, int $limit = 100, string $sort = null, string $order = 'asc'): Documents
    {
        $order = $this->convertToSortingInteger($order);

        if ($sort) {
            $sort = ['meta.' . $sort => $order];
        }

        $result = $this->mapMongoDocumentsToDocuments(
            $this->documentCollection
                ->find(
                    $search->flattenedMetaSearch(),
                    [
                        'skip'  => $offset,
                        'limit' => $limit,
                        'sort'  => $sort,
                    ]
                )
                ->toArray()
        );

        return $result;
    }

    private function mapMongoDocumentsToDocuments($mongoDocuments): Documents
    {
        $documentCollection = Documents::empty();

        /** @var BSONDocument $mongoDocument */
        foreach ($mongoDocuments as $mongoDocument) {
            $fileData = new FileData(
                FileId::fromString($mongoDocument->fileData->id),
                $mongoDocument->fileData->mime_type,
                $mongoDocument->fileData->extension
            );

            $document = new Document(
                DocumentId::fromString($mongoDocument->id),
                $fileData,
                $mongoDocument->meta->getArrayCopy()
            );

            $documentCollection = $documentCollection->add($document);
        }

        return $documentCollection;
    }

    private function convertToSortingInteger(string $order): int
    {
        switch (mb_strtolower($order)) {
            case 'desc':
                return -1;
            case 'asc':
            default:
                return 1;
        }
    }
}

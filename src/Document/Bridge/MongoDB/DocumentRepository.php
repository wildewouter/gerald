<?php

namespace Document\Bridge\MongoDB;

use Document\Domain\Document;
use Document\Domain\DocumentFileStorage;
use Document\Domain\DocumentId;
use Document\Domain\DocumentRepository as DomainRepository;
use Document\Domain\Documents;
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
    public function getAllDocuments(): Documents
    {
        return $this->mapMongoDocumentsToDocuments($this->documentCollection->find());
    }

    public function getDocumentById(DocumentId $id): Document
    {
        $documents = $this->mapMongoDocumentsToDocuments($this->documentCollection->find(['id' => (string) $id]));

        return $documents->first();
    }

    public function save(Document $document = null): Document
    {
        $result = $this->documentCollection->insertOne($document->toArray());

        if (! $result->isAcknowledged()) {
            throw new DocumentStorageFailedException();
        }

        return $document;
    }


    private function mapMongoDocumentsToDocuments($mongoDocuments)
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
}

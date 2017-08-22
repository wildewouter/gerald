<?php

namespace Tests\Unit\Document\Domain;

use Document\Domain\Document;
use Document\Domain\DocumentId;
use Document\Domain\FileData;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;

class DocumentTest extends TestCase
{
    public function testSerializeToArrayDefault()
    {
        $fileDataArray = ['someFileData'];

        /** @var FileData|ObjectProphecy $fileDataMock */
        $fileDataMock = $this->prophesize(FileData::class);
        $fileDataMock->toArray()->willReturn($fileDataArray);

        $createdDate = new \DateTimeImmutable();
        $meta        = ['some' => 'meta'];

        $document = new Document(
            DocumentId::fromString('asdf'),
            $fileDataMock->reveal(),
            $meta,
            $createdDate
        );

        $expected = [
            'id'       => 'asdf',
            'meta'     => $meta,
            'fileData' => $fileDataArray,
            'created'  => $createdDate->format('Y-m-d H:i:s'),
        ];

        $this->assertEquals($expected, $document->toArray());
    }

    public function testSerializeToArrayWithUpdatedDate()
    {
        $fileDataArray = ['someFileData'];

        /** @var FileData|ObjectProphecy $fileDataMock */
        $fileDataMock = $this->prophesize(FileData::class);
        $fileDataMock->toArray()->willReturn($fileDataArray);

        $createdDate = new \DateTimeImmutable();
        $updatedDate = new \DateTimeImmutable('+6 minutes');
        $meta        = ['some' => 'meta'];

        $document = new Document(
            DocumentId::fromString('asdf'),
            $fileDataMock->reveal(),
            $meta,
            $createdDate,
            $updatedDate
        );

        $expected = [
            'id'       => 'asdf',
            'meta'     => $meta,
            'fileData' => $fileDataArray,
            'created'  => $createdDate->format('Y-m-d H:i:s'),
            'updated'  => $updatedDate->format('Y-m-d H:i:s'),
        ];

        $this->assertEquals($expected, $document->toArray());
    }

    public function testSerializeToArrayWithDeletedDate()
    {
        $fileDataArray = ['someFileData'];

        /** @var FileData|ObjectProphecy $fileDataMock */
        $fileDataMock = $this->prophesize(FileData::class);
        $fileDataMock->toArray()->willReturn($fileDataArray);

        $createdDate = new \DateTimeImmutable();
        $updatedDate = null;
        $deletedDate = new \DateTimeImmutable('+8 minutes');
        $meta        = ['some' => 'meta'];

        $document = new Document(
            DocumentId::fromString('asdf'),
            $fileDataMock->reveal(),
            $meta,
            $createdDate,
            $updatedDate,
            $deletedDate
        );

        $expected = [
            'id'       => 'asdf',
            'meta'     => $meta,
            'fileData' => $fileDataArray,
            'created'  => $createdDate->format('Y-m-d H:i:s'),
            'deleted'  => $deletedDate->format('Y-m-d H:i:s'),
        ];

        $this->assertEquals($expected, $document->toArray());
    }
}

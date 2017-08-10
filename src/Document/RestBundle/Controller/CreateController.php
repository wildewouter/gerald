<?php

namespace Document\RestBundle\Controller;

use Document\Domain\Document;
use Document\Domain\DocumentId;
use Document\Domain\FileData;
use Document\Domain\FileId;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class CreateController extends Controller
{
    /**
     * @Route("/", name="document.create")
     * @Method("POST")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createAction(Request $request)
    {
        $documentRepository = $this->get('document.repository');
        $documentFileStorage = $this->get('document.filestorage');

        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('file');
        $meta = json_decode($request->get('meta', '[]'), true);

        $fileData = new FileData(
            FileId::createNew(),
            $uploadedFile->getMimeType(),
            $uploadedFile->getClientOriginalExtension()
        );
        $document = new Document(DocumentId::createNew(), $fileData, $meta);

        $documentFileStorage->store($fileData, $uploadedFile);
        $documentRepository->save($document);

        return new JsonResponse($document->toArray(), 201);

    }
}

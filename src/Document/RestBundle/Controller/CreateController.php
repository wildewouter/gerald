<?php

namespace Document\RestBundle\Controller;

use DateTimeImmutable;
use Document\Domain\Document;
use Document\Domain\DocumentId;
use Document\Domain\FileData;
use Document\Domain\FileId;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class CreateController extends Controller
{
    /**
     * @Route("/", name="document.rest.create")
     * @Method("POST")
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Create a new document",
     *  parameters={
     *      {"name"="file", "dataType"="file", "format"="binary", "required"=true, "description"="File to store"},
     *      {"name"="meta", "dataType"="string", "format"="json", "required"=true, "description"="The given meta data for the file as a json object"}
     *  }
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function createAction(Request $request)
    {
        $documentRepository  = $this->get('document.repository');
        $documentFileStorage = $this->get('document.filestorage');

        $uploadedFile = $this->getFileFromRequest($request);

        $meta = json_decode($request->get('meta', '{}'), true);
        $this->ensureMetaIsString($meta);

        $fileData = new FileData(
            FileId::createNew(),
            $uploadedFile->getMimeType(),
            $uploadedFile->getClientOriginalExtension()
        );
        $document = new Document(DocumentId::createNew(), $fileData, $meta, new DateTimeImmutable('now'));

        $documentFileStorage->store($fileData, $uploadedFile);
        $documentRepository->save($document);

        return new JsonResponse($document->toArray(), 201);
    }

    /**
     * @param Request $request
     * @return UploadedFile
     *
     * @throws BadRequestHttpException
     */
    private function getFileFromRequest(Request $request): UploadedFile
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->files->get('file');

        if (! $uploadedFile) {
            throw new BadRequestHttpException();
        }

        return $uploadedFile;
    }

    private function ensureMetaIsString(&$meta)
    {
        foreach ($meta as $key => $value) {
            $meta[$key] = (string) $value;
        }
    }
}

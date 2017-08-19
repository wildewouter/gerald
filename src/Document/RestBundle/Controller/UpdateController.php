<?php

namespace Document\RestBundle\Controller;

use DateTimeImmutable;
use Document\Domain\Document;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class UpdateController extends Controller
{
    /**
     * @Route("/{documentId}/", name="document.rest.update")
     * @Method("PUT")
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Update a document",
     *  requirements={
     *     {
     *          "name"="documentId",
     *          "dataType"="string",
     *          "requirement"="\w+",
     *          "description"="ID of the requested document"
     *      }
     *  },
     *  parameters={
     *      {"name"="meta", "dataType"="string", "format"="json", "required"=true, "description"="The given meta data for the file as a json object"}
     *  }
     * )
     *
     * @param Request $request
     * @param Document $document
     * @return Response
     */
    public function updateAction(Document $document, Request $request)
    {
        $meta = json_decode($request->get('meta', '{}'), true);
        $this->ensureMetaIsString($meta);

        $meta = array_replace($document->meta(), $meta);

        $id                 = $document->id();
        $documentRepository = $this->get('document.repository');

        $documentRepository->delete($id, false);

        $document = new Document(
            $id,
            $document->fileData(),
            $meta,
            $document->createdDate(),
            new DateTimeImmutable('now')
        );

        $documentRepository->save($document);

        return new JsonResponse($document->toArray());
    }

    private function ensureMetaIsString(&$meta)
    {
        foreach ($meta as $key => $value) {
            $meta[$key] = (string) $value;
        }
    }
}

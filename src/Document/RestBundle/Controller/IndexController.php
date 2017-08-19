<?php

namespace Document\RestBundle\Controller;

use Document\Domain\Document;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

final class IndexController extends Controller
{
    /**
     * @Route("/{documentId}/", name="document.rest.item")
     * @Method("GET")
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get a document by id",
     *  requirements={
     *      {
     *          "name"="documentId",
     *          "dataType"="string",
     *          "requirement"="\w+",
     *          "description"="ID of the requested document"
     *      }
     *  },
     * )
     *
     * @param Document $document
     * @return JsonResponse
     */
    public function showAction(Document $document)
    {
        return new JsonResponse($document->toArray());
    }

    /**
     * @Route("/", name="document.rest.collection")
     * @Method("GET")
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Get all documents",
     * )
     */
    public function collectionAction()
    {
        $documentRepository = $this->get('document.repository');
        $documents          = $documentRepository->findAll();

        return new JsonResponse($documents->toArray());
    }
}

<?php

namespace Document\RestBundle\Controller;

use Document\Domain\DocumentId;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

final class IndexController extends Controller
{
    /**
     * @Route("/{id}/", name="document.item")
     * @Method("GET")
     *
     * @param DocumentId $id
     * @return JsonResponse
     */
    public function showAction(DocumentId $id)
    {
        $documentRepository = $this->get('document.repository');
        $document           = $documentRepository->getDocumentById($id);

        return new JsonResponse($document->toArray());
    }

    /**
     * @Route("/", name="document.collection")
     * @Method("GET")
     */
    public function collectionAction()
    {
        $documentRepository = $this->get('document.repository');
        $documents          = $documentRepository->getAllDocuments();

        return new JsonResponse($documents->toArray());
    }
}

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
     * @Route("/{id}/", name="document.rest.item")
     * @Method("GET")
     *
     * @param DocumentId $id
     * @return JsonResponse
     */
    public function showAction(DocumentId $id)
    {
        $documentRepository = $this->get('document.repository');
        $document           = $documentRepository->findById($id);

        return new JsonResponse($document->toArray());
    }

    /**
     * @Route("/", name="document.rest.collection")
     * @Method("GET")
     */
    public function collectionAction()
    {
        $documentRepository = $this->get('document.repository');
        $documents          = $documentRepository->findAll();

        return new JsonResponse($documents->toArray());
    }
}

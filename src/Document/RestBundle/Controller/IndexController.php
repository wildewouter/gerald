<?php

namespace Document\RestBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class IndexController extends Controller
{
    /**
     * @Route("/{id}/", name="document.item")
     * @Method("GET")
     */
    public function showAction($id)
    {
        return new Response('Hello World');
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

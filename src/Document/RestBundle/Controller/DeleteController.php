<?php

namespace Document\RestBundle\Controller;

use Document\Domain\Document;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

final class DeleteController extends Controller
{
    /**
     * @Route("/{documentId}/", name="document.rest.delete")
     * @Method("DELETE")
     *
     * @param Document $document
     * @return Response
     */
    public function deleteAction(Document $document)
    {
        $documentRepository = $this->get('document.repository');

        $documentRepository->delete($document->id());

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}

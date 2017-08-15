<?php

namespace Document\RestBundle\Controller;

use Document\Domain\DocumentSearch;
use Document\Domain\DocumentSearchQuery;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class SearchController extends Controller
{
    /**
     * @Route("/search/", name="document.rest.search")
     * @Method("GET")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function searchAction(Request $request)
    {
        $documentSearch = $this->createDocumentSearchFromRequest($request);

        $documentRepository = $this->get('document.repository');

        $result = $documentRepository->search($documentSearch);

        return new JsonResponse($result->toArray());
    }

    private function createDocumentSearchFromRequest(Request $request): DocumentSearch
    {
        $queryItems = json_decode($request->get('q', '{}'), true);

        $documentQueryList = [];

        foreach ($queryItems as $key => $value) {
            $documentQueryList[] = new DocumentSearchQuery($key, $value);
        }

        return DocumentSearch::fromArray($documentQueryList);
    }
}

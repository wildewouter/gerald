<?php

namespace Document\RestBundle\Controller;

use Document\Domain\DocumentSearch;
use Document\Domain\DocumentSearchQuery;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
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
     * @ApiDoc(
     *  resource=true,
     *  description="Create a new document",
     *  parameters={
     *      {"name"="q", "dataType"="string", "required"=false, "description"="The search query in JSON Format ({'DocumentSpecialName':'Name'})"},
     *      {"name"="offset", "dataType"="integer", "required"=false, "description"="Offset of the search"},
     *      {"name"="limit", "dataType"="integer", "required"=false, "description"="Limit of the search"},
     *      {"name"="sort", "dataType"="string", "required"=false, "description"="The item to sort the search on"},
     *      {"name"="order", "dataType"="string", "required"=false, "description"="ASC or DESC"}
     *  }
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function searchAction(Request $request)
    {
        $documentSearch = $this->createDocumentSearchFromRequest($request);

        $documentRepository = $this->get('document.repository');

        $offset = (int) $request->get('offset', 0);
        $limit  = (int) $request->get('limit', 100);
        $sort   = $request->get('sort', null);
        $order  = $request->get('order', 'asc');

        $result = $documentRepository->search($documentSearch, $offset, $limit, $sort, $order);

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

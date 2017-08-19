<?php

namespace Document\RestBundle\ParamConverter;

use Document\Domain\Document;
use Document\Domain\DocumentId;
use Document\Domain\DocumentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class DocumentParamConverter implements ParamConverterInterface
{
    /**
     * @var DocumentRepository
     */
    private $documentRepository;

    public function __construct(DocumentRepository $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }

    /**
     * Stores the object in the request.
     *
     * @param Request $request The request
     * @param ParamConverter $configuration Contains the name, class and options of the object
     *
     * @return bool True if the object has been successfully set, else false
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $id = $request->attributes->get('documentId', null);

        if ($id === null) {
            return false;
        }

        $document = $this->documentRepository->findById(DocumentId::fromString($id));

        if (! $document) {
            throw new NotFoundHttpException();
        }

        $request->attributes->set('document', $document);

        return true;
    }

    /**
     * Checks if the object is supported.
     *
     * @param ParamConverter $configuration Should be an instance of ParamConverter
     *
     * @return bool True if the object is supported, else false
     */
    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === Document::class;
    }
}

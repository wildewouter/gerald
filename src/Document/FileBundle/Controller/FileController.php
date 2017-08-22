<?php

namespace Document\FileBundle\Controller;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class FileController extends Controller
{
    /**
     * @Route("/file/{fileName}", name="document.file.download")
     * @Method("GET")
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Create a new document",
     *  requirements={
     *      {
     *          "name"="fileName",
     *          "dataType"="string",
     *          "requirement"="\w+",
     *          "description"="Name of the requested file"
     *      }
     *  },
     * )
     *
     * @param string $fileName
     * @return StreamedResponse
     */
    public function downloadAction(string $fileName)
    {
        $document   = $this->get('document.repository')->findByFileName($fileName);
        $fileHandle = $this->get('document.filestorage')->get($fileName);

        if (! $fileHandle) {
            throw new NotFoundHttpException('File not found');
        }

        $response = new StreamedResponse(function () use ($fileHandle) {
            while (! feof($fileHandle)) {
                echo fread($fileHandle, 1024);
                flush();
            }
            fclose($fileHandle);
        }, 200);

        $response->headers->set('Content-Type', $document->fileData()->mimeType());

        return $response;
    }
}

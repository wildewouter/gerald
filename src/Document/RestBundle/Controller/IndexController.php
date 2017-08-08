<?php

namespace Document\RestBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class IndexController extends Controller
{
    /**
     * @Route("/", name="document.index")
     * @Method("GET")
     */
    public function showAction()
    {
        return new Response('Hello World');
    }

    public function collectionAction(Request $request)
    {

    }
}

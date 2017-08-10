<?php

namespace MainBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

final class TestController extends Controller
{
    /**
     * @Route("/test/", name="test.page")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }
}

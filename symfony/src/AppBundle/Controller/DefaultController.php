<?php

namespace AppBundle\Controller;

use Doctrine\ODM\MongoDB\DocumentManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/test")
     */
    public function testAction(Request $request)
    {
        /** @var DocumentManager $dm */
        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->getConnection()->connect();
        $isConnected = $dm->getConnection()->isConnected();

        return new Response(
            "<html><body>Is connected to Mongo: $isConnected</body></html>"
        );
    }
}

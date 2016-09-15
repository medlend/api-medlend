<?php

namespace MedlendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends FOSRestController
{

    public function indexAction()
    {
        return $this->render('MedlendBundle:Default:index.html.twig');
    }
    /**
     * @Rest\Get("/medlend")
     */
    public function index2Action(Request $request)
    {
        $view = $this->view(['hello' => 'world'], Response::HTTP_OK);

        return $view;
    }
}

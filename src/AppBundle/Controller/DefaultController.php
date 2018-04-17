<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * Action indexAction
     * @return Response
     *
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig', array());
    }

    /**
     * @Route("/sobre", name="sobre")
     */
    public function sobreAction()
    {
        return $this->render('default/sobre.html.twig', array());
    }
}

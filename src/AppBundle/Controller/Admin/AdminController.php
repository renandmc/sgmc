<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{

    /**
     * Action indexAction
     * @return Response
     *
     * @Route("/admin", name="admin_home")
     */
    public function indexAction()
    {
        return $this->render('admin/index.html.twig', array());
    }

}
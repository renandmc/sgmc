<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{

    /**
     * Action indexAction - Página inicial administrativa
     * @return Response
     *
     * @Route("/admin", name="admin_home")
     */
    public function indexAction()
    {
        if ($this->getUser()->isRepresentante()){
            return $this->redirectToRoute('admin_ordens_index');
        }
        return $this->render('admin/index.html.twig', array());
    }

}
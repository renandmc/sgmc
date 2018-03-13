<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/admin/usuarios")
 */
class UsuarioController extends Controller
{
    /**
     * @Route("/", name="admin_usuarios_index")     
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usuarios = $em->getRepository('AppBundle:Usuario')->findAll();
        return $this->render('admin/usuario/index.html.twig', array('usuarios' => $usuarios));
    }

}
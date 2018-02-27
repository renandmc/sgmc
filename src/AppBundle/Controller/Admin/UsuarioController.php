<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        return $this->render('usuario/index.html.twig', array(
            'usuarios' => $usuarios,
        ));
    }

}
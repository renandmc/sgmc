<?php


namespace AppBundle\Controller\Admin;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("/admin/usuario", name="user_home")
     */
    public function indexAction(Request $request)
    {
        $usuario = $this->getDoctrine()->getRepository('AppBundle:User')->find(1);
        if (!$usuario) {
            throw $this->createNotFoundException('Nenhum usuario');
        }
        return new Response('Usuario: ' . $usuario->getName());
        //return $this->render('admin/user/index.html.twig', array());
    }

    /**
     * @Route("/admin/usuario/novo", name="user_new")
     */
    public function newAction()
    {
        $usuario = new User();
        $usuario->setName("Renan");
        $usuario->setPassword("12345");

        $em = $this->getDoctrine()->getManager();
        $em->persist($usuario);
        $em->flush();

        return new Response('Salvo usuario' . $usuario->getId());
    }
}
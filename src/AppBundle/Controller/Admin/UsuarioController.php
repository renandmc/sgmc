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
        return $this->render('usuario/index.html.twig', array('usuarios' => $usuarios));
    }
    
    /**
     * @Route("/novo", name="admin_usuarios_novo")     
     */
    public function novoAction(Request $request)
    {
        $usuario = new Usuario();
        $form = $this->createForm('AppBundle\Form\UsuarioType', $usuario);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $encoder = $this->get('security.password_encoder');
            $password = $encoder->encodePassword($usuario, $usuario->getPlainPassword());
            $usuario->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();            
        }
        return $this->render('usuario/novo.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/info/{id}", name="admin_usuarios_info")     
     */
    public function infoAction(Usuario $usuario)
    {        
        return $this->render('usuario/info.html.twig', array('usuario' => $usuario));
    }

    /**
     * @Route("/editar/{id}", name="admin_usuarios_editar")     
     */
    public function editarAction(Request $request, Usuario $usuario)
    {        
        $form = $this->createForm('AppBundle\Form\UsuarioType', $usuario);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_usuarios_editar', array('id' => $usuario->getId()));
        }
        return $this->render('usuario/editar.html.twig', array('usuario' => $usuario, 'form' => $form->createView()));
    }

    /**
     * @Route("/excluir/{id}", name="admin_usuarios_excluir")    
     */
    public function excluirAction(Request $request, Usuario $usuario)
    {
        $form = null;
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($usuario);
            $em->flush();
        }        
        return $this->render('usuario/excluir.html.twig', array('usuario' => $usuario));
    }
    
}
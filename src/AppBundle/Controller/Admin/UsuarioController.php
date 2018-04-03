<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("admin/usuarios")
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

    /**
     * @Route("/novo", name="admin_usuarios_novo")
     */
    public function novoAction(Request $request)
    {
        $usuario = new Usuario();
        $form = $this->createForm('AppBundle\Form\UsuarioType', $usuario);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if ($usuario->getTipo() == 'Professor'){
                $usuario->setAdmin(true);
            } elseif ($usuario->getTipo() == 'Administrador'){
                $usuario->setSuperAdmin(true);
            }
            $usuario->setEnabled(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();
            $this->addFlash('success', 'Usuário adicionado');
            return $this->redirectToRoute('admin_usuarios_index');
        }
        return $this->render('admin/usuario/novo.html.twig', array('usuario' => $usuario, 'form' => $form->createView()));
    }

    /**
     * @Route("/excluir/{id}", name="admin_usuarios_excluir")
     */
    public function excluirAction(Request $request, Usuario $usuario)
    {
        if ($request->getMethod() == 'POST') {
            if ($request->get('del') == 'Sim') {
                if ($this->getUser() != $usuario) {
                    $em = $this->getDoctrine()->getManager();
                    $em->remove($usuario);
                    $em->flush();
                    $this->addFlash('warning', 'Usuário excluído');
                } else {
                    $this->addFlash('danger', 'Não é possível excluir o usuário logado');
                }
            }
            return $this->redirectToRoute('admin_usuarios_index');
        }
        return $this->render('admin/usuario/excluir.html.twig', array('usuario' => $usuario));
    }
}
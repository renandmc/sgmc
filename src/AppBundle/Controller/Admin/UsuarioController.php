<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Usuario;
use AppBundle\Form\UsuarioType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UsuarioController
 * @package AppBundle\Controller\Admin
 *
 * @Route("admin/usuarios")
 */
class UsuarioController extends Controller
{
    /**
     * Action indexAction
     * @return Response
     *
     * @Route("/", name="admin_usuarios_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usuarios = $em->getRepository('AppBundle:Usuario')->findAll();
        return $this->render('admin/usuario/index.html.twig', array('usuarios' => $usuarios));
    }

    /**
     * Action infoAction
     * @param Usuario $usuario
     * @return Response
     *
     * @Route("/info/{id}", name="admin_usuarios_info")
     */
    public function infoAction(Usuario $usuario)
    {
        return $this->render('admin/usuario/info.html.twig', array('usuario' => $usuario));
    }

    /**
     * Action novoAction
     * @param Request $request
     * @return RedirectResponse|Response
     *
     * @Route("/novo", name="admin_usuarios_novo")
     */
    public function novoAction(Request $request)
    {
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            switch ($usuario->getTipo()){
                case Usuario::ADMIN:
                    $usuario->addRole(Usuario::ROLE_SUPER_ADMIN);
                    break;
                case Usuario::PROF:
                    $usuario->addRole(Usuario::ROLE_ADMIN);
                    break;
                case Usuario::REP:
                    $usuario->addRole(Usuario::ROLE_DEFAULT);
                    break;
            }
            $senha = $this->get('security.password_encoder')->encodePassword($usuario, $usuario->getSenhaLimpa());
            $usuario->setSenha($senha);
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();
            $this->addFlash('success', 'Usuário adicionado');
            return $this->redirectToRoute('admin_usuarios_index');
        }
        return $this->render('admin/usuario/novo.html.twig', array('usuario' => $usuario, 'form' => $form->createView()));
    }

    /**
     * Action excluirAction
     *
     * @param Request $request
     * @param Usuario $usuario
     * @return RedirectResponse|Response
     *
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
                }
            }
            return $this->redirectToRoute('admin_usuarios_index');
        }
        return $this->render('admin/usuario/excluir.html.twig', array('usuario' => $usuario));
    }
}
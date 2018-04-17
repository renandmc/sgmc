<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Usuario;
use AppBundle\Form\UsuarioType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
        $usuarios = $this->getDoctrine()->getRepository('AppBundle:Usuario')->findAll();
        return $this->render('usuarios/index.html.twig', array('usuarios' => $usuarios));
    }

    /**
     * Action infoAction
     * @param int $id
     * @return Response
     *
     * @Route("/info/{id}", name="admin_usuarios_info")
     */
    public function infoAction($id)
    {
        $usuario = $this->getDoctrine()->getRepository('AppBundle:Usuario')->find($id);
        if (!$usuario){
            $this->createNotFoundException("Nenhum usuário cadastrado com ID: $id");
        }
        return $this->render('usuarios/info.html.twig', array('usuario' => $usuario));
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
            $senha = $this->get('security.password_encoder')->encodePassword($usuario, $usuario->getSenhaLimpa());
            $usuario->setSenha($senha);
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();
            $this->addFlash('success', 'Usuário adicionado');
            return $this->redirectToRoute('admin_usuarios_index');
        }
        return $this->render('usuarios/novo.html.twig', array('usuario' => $usuario, 'form' => $form->createView()));
    }

    /**
     * Action excluirAction
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     *
     * @Route("/excluir/{id}", name="admin_usuarios_excluir")
     */
    public function excluirAction(Request $request, $id)
    {
        $usuario = $this->getDoctrine()->getRepository('AppBundle:Usuario')->find($id);
        if (!$usuario){
            $this->createNotFoundException("Nenhum usuário cadastrado com ID: $id");
        }
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
        return $this->render('usuarios/excluir.html.twig', array('usuario' => $usuario));
    }

}
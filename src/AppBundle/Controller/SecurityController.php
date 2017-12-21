<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Form\UsuarioType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $authUtils = $this->get('security.authentication_utils');
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();
        return $this->render('security/login.html.twig', array('last_username' => $lastUsername, 'error' => $error));
    }

    /**
     * @Route("/registrar", name="security_registrar")
     */
    public function registrarAction(Request $request)
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
        return $this->render(
            'security/registrar.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/login_check", name="security_login_check")
     */
    public function loginCheckAction()
    {
        throw new \Exception('This should never be reached!');
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logoutAction()
    {
        throw new \Exception('This should never be reached!');
    }
}
<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SecurityController
 * @package AppBundle\Controller
 */
class SecurityController extends Controller
{

    /**
     * Action loginAction
     * @param Request $request
     * @return Response
     *
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
        $authUtils = $this->get('security.authentication_utils');
        // Pega o erro de login caso tenha algum
        $erro = $authUtils->getLastAuthenticationError();
        // Último login digitado pelo usuário
        $ultimoUsuario = $authUtils->getLastUsername();
        return $this->render('security/login.html.twig', array('ultimo_usuario' => $ultimoUsuario, 'erro' => $erro));
    }

}
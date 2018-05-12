<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FaleConoscoController
 * @package AppBundle\Controller\Admin
 *
 * @Route("admin/faleconosco")
 */
class FaleConoscoController extends Controller
{

    /**
     * Action indexAction - Lista de todas mensagens
     * @return Response
     *
     * @Route("/", name="admin_faleconosco_index")
     */
    public function indexAction(Request $request)
    {
        // busca as sugestões no banco
        $mensagens = $this->getDoctrine()->getRepository('AppBundle:FaleConosco')->findAll();
        // carrega o paginador
        $paginator = $this->get('knp_paginator');
        // faz a paginação com as sugestões, utilizando limite de 5 por página
        $pagination = $paginator->paginate($mensagens,$request->query->get('pag', 1),5);
        // carrega a página
        return $this->render('faleconosco/index.html.twig', array('mensagens' => $pagination));
    }
    
}
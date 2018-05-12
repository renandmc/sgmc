<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\FaleConosco;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
        $mensagens = $this->getDoctrine()->getRepository(FaleConosco::class)->findAll();
        // carrega o paginador
        $paginator = $this->get('knp_paginator');
        // faz a paginação com as sugestões, utilizando limite de 5 por página
        $pagination = $paginator->paginate($mensagens,$request->query->get('pag', 1),5);
        // carrega a página
        return $this->render('faleconosco/index.html.twig', array('mensagens' => $pagination));
    }

    /**
     * Action excluirAction - Excluir uma mensagem
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     *
     * @Route("/excluir/{id}", name="admin_faleconosco_excluir")
     */
    public function excluirAction(Request $request, $id)
    {
        $mensagem = $this->getDoctrine()->getRepository(FaleConosco::class)->find($id);
        if(!$mensagem){
            $this->createNotFoundException('Nenhuma mensagem cadastrado com ID: ' . $id);
        }
        if($request->getMethod() == 'POST'){
            if($request->get('del') == 'Sim'){
                $em = $this->getDoctrine()->getManager();
                $em->remove($mensagem);
                $em->flush();
                $this->addFlash('warning','Mensagem excluída');
            }
            return $this->redirectToRoute('admin_faleconosco_index');
        }
        return $this->render('faleconosco/excluir.html.twig', array('mensagem' => $mensagem));
    }
}
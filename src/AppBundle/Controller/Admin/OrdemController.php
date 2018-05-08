<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Equipamento;
use AppBundle\Entity\Ordem;
use AppBundle\Entity\Setor;
use AppBundle\Form\OrdemType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OrdemController
 * @package AppBundle\Controller\Admin
 *
 * @Route("admin/ordens")
 */
class OrdemController extends Controller
{

    /**
     * Action indexAction
     * @return Response
     *
     * @Route("/", name="admin_ordens_index")
     */
    public function indexAction(Request $request)
    {
        if ($this->getUser()->isRepresentante()){
            $ordens = $this->getDoctrine()->getRepository(Ordem::class)->findBy(array("criadoPor" => $this->getUser()));
        }else{
            $ordens = $this->getDoctrine()->getRepository(Ordem::class)->findAll();
        }
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($ordens,$request->query->get('pag',1),5);
        return $this->render('ordens/index.html.twig', array('ordens' => $pagination));
    }

    /**
     * Action infoAction
     * @param int $id
     * @return Response
     *
     * @Route("/info/{id}", name="admin_ordens_info")
     */
    public function infoAction($id)
    {
        $ordem = $this->getDoctrine()->getRepository(Ordem::class)->find($id);
        if(!$ordem){
            $this->createNotFoundException("Nenhuma ordem cadastrada com ID: $id");
        }
        return $this->render('ordens/info.html.twig', array('ordem' => $ordem));
    }

    /**
     * Action buscarEsquipamentoAction
     * @return Response
     *
     * @Route("/busca", name="admin_ordens_busca")
     */
    public function buscarEquipamentoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $setores = $em->getRepository(Setor::class)->findAll();
        return $this->render('ordens/busca.html.twig', array('setores' => $setores));
    }

    /**
     * Action novoAction
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     *
     * @Route("/novo/{id}", name="admin_ordens_novo")
     */
    public function novoAction(Request $request, $id)
    {
        $equipamento = $this->getDoctrine()->getRepository(Equipamento::class)->find($id);
        $ordem = new Ordem();
        $form = $this->createForm(OrdemType::class, $ordem);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $ordem->setEquipamento($equipamento);
            $em->persist($ordem);
            $em->flush();
            $this->addFlash('success','Ordem criada');
            return $this->redirectToRoute('admin_ordens_index');
        }
        return $this->render('ordens/novo.html.twig', array('ordem' => $ordem, 'equipamento' => $equipamento, 'form' => $form->createView()));
    }

    /**
     * Action editarAction
     * @param Request $request
     * @param Ordem $ordem
     * @return RedirectResponse|Response
     *
     * @Route("/editar/{id}", name="admin_ordens_editar")
     */
    public function editarAction(Request $request, Ordem $ordem)
    {
        $form = $this->createForm(OrdemType::class, $ordem);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Ordem editada');
            return $this->redirectToRoute('admin_ordens_index');
        }
        return $this->render('ordens/editar.html.twig', array('ordem' => $ordem, 'form' => $form->createView()));
    }

    /**
     * Action fecharAction
     * @param Request $request
     * @param Ordem $ordem
     * @return RedirectResponse|Response
     *
     * @Route("/fechar/{id}", name="admin_ordens_fechar")
     */
    public function fecharAction(Request $request, Ordem $ordem)
    {
        if ($request->getMethod() == 'POST'){
            if ($request->get('fecha') == 'Sim'){
                $ordem->fechaOrdem();
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'Ordem fechada');
                return $this->redirectToRoute('admin_ordens_index');
            }
        }
        return $this->render('ordens/fechar.html.twig', array('ordem' => $ordem));
    }

    /**
     * Action excluirAction
     * @param Request $request
     * @param Ordem $ordem
     * @return RedirectResponse|Response
     *
     * @Route("/excluir/{id}", name="admin_ordens_excluir")
     */
    public function excluirAction(Request $request, Ordem $ordem)
    {
        if($request->getMethod() == 'POST'){
            if($request->get('del') == 'Sim'){
                $em = $this->getDoctrine()->getManager();
                $em->remove($ordem);
                $em->flush();
                $this->addFlash('warning','Ordem excluída');
            }
            return $this->redirectToRoute('admin_ordens_index');
        }
        return $this->render('ordens/excluir.html.twig', array('ordem' => $ordem));
    }
}
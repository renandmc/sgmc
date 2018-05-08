<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Turma;
use AppBundle\Form\TurmaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TurmaController
 * @package AppBundle\Controller\Admin
 *
 * @Route("admin/turmas")
 */
class TurmaController extends Controller
{

    /**
     * Action indexAction
     * @return Response
     *
     * @Route("/", name="admin_turmas_index")
     */
    public function indexAction(Request $request)
    {
        $turmas = $this->getDoctrine()->getRepository('AppBundle:Turma')->findAll();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($turmas,$request->query->get('pag',1),5);
        return $this->render('turmas/index.html.twig', array('turmas' => $pagination));
    }

    /**
     * Action infoAction
     * @param int $id
     * @return Response
     *
     * @Route("/info/{id}", name="admin_turmas_info")
     */
    public function infoAction($id)
    {
        $turma = $this->getDoctrine()->getRepository('AppBundle:Turma')->find($id);
        if (!$turma){
            $this->createNotFoundException("Nenhuma turma cadastrada com ID: $id");
        }
        return $this->render('turmas/info.html.twig', array('turma' => $turma));
    }

    /**
     * Action novoAction
     * @param Request $request
     * @return RedirectResponse|Response
     *
     * @Route("/novo", name="admin_turmas_novo")
     */
    public function novoAction(Request $request)
    {
        $turma = new Turma();
        $form = $this->createForm(TurmaType::class, $turma);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($turma);
            $em->flush();
            $this->addFlash('success','Turma criada');
            return $this->redirectToRoute('admin_turmas_index');
        }
        return $this->render('turmas/novo.html.twig', array('turma' => $turma, 'form' => $form->createView()));
    }

    /**
     * Action editarAction
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     *
     * @Route("/editar/{id}", name="admin_turmas_editar")
     */
    public function editarAction(Request $request, $id)
    {
        $turma = $this->getDoctrine()->getRepository('AppBundle:Turma')->find($id);
        if (!$turma){
            $this->createNotFoundException("Nenhuma turma cadastrada com ID: $id");
        }
        $form = $this->createForm(TurmaType::class, $turma);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','Turma editada');
            return $this->redirectToRoute('admin_turmas_index');
        }
        return $this->render('turmas/editar.html.twig', array('turma' => $turma, 'form' => $form->createView()));
    }

    /**
     * Action excluirAction
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     *
     * @Route("/excluir/{id}", name="admin_turmas_excluir")
     */
    public function excluirAction(Request $request, $id)
    {
        $turma = $this->getDoctrine()->getRepository('AppBundle:Turma')->find($id);
        if (!$turma){
            $this->createNotFoundException("Nenhuma turma cadastrada com ID: $id");
        }
        if ($request->getMethod() == 'POST'){
            if ($request->get('del') == 'Sim'){
                $em = $this->getDoctrine()->getManager();
                $em->remove($turma);
                $em->flush();
                $this->addFlash('warning','Turma excluída');
            }
            return $this->redirectToRoute('admin_turmas_index');
        }
        return $this->render('turmas/excluir.html.twig', array('turma' => $turma));
    }
}
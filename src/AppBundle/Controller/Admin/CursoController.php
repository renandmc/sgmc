<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Curso;
use AppBundle\Form\CursoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class CursoController
 * @package AppBundle\Controller\Admin
 *
 * @Route("admin/cursos")
 */
class CursoController extends Controller
{

    /**
     * Action indexAction - Lista de todos os cursos
     * @return Response
     *
     * @Route("/", name="admin_cursos_index")
     */
    public function indexAction(Request $request)
    {
        // busca os cursos no banco
        $cursos = $this->getDoctrine()->getRepository('AppBundle:Curso')->findAll();
        // carrega o paginador
        $paginator = $this->get('knp_paginator');
        // faz a paginação com os cursos, utilizando limite de 5 por página
        $pagination = $paginator->paginate($cursos,$request->query->get('pag', 1),5);
        // carrega a página
        return $this->render('cursos/index.html.twig', array('cursos' => $pagination));
    }

    /**
     * Action infoAction - Informações sobre um curso específico
     * @param int $id
     * @return Response
     *
     * @Route("/info/{id}", name="admin_cursos_info")
     */
    public function infoAction($id)
    {
        $curso = $this->getDoctrine()->getRepository('AppBundle:Curso')->find($id);
        if (!$curso){
            $this->createNotFoundException('Nenhum curso cadastrado com ID: ' . $id);
        }
        return $this->render('cursos/info.html.twig', array('curso' => $curso));
    }

    /**
     * Action novoAction - Criação de um novo curso
     * @param Request $request
     * @return RedirectResponse|Response
     *
     * @Route("/novo", name="admin_cursos_novo")
     */
    public function novoAction(Request $request)
    {
        $curso = new Curso();
        $form = $this->createForm(CursoType::class, $curso);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($curso);
            $em->flush();
            $this->addFlash('success',"Curso criado");
            return $this->redirectToRoute('admin_cursos_index');
        }
        return $this->render('cursos/novo.html.twig', array('curso' => $curso, 'form' => $form->createView()));
    }

    /**
     * Action editarAction - Edição de um curso
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     *
     * @Route("/editar/{id}", name="admin_cursos_editar")
     */
    public function editarAction(Request $request, $id)
    {
        $curso = $this->getDoctrine()->getRepository('AppBundle:Curso')->find($id);
        if (!$curso){
            $this->createNotFoundException('Nenhum curso cadastrado com ID: ' . $id);
        }
        $editForm = $this->createForm(CursoType::class, $curso);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','Curso editado');
            return $this->redirectToRoute('admin_cursos_index');
        }
        return $this->render('cursos/editar.html.twig', array('curso' => $curso, 'form' => $editForm->createView()));
    }

    /**
     * Action excluirAction - Exclusão de um curso
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     *
     * @Route("/excluir/{id}", name="admin_cursos_excluir")
     */
    public function excluirAction(Request $request, $id)
    {
        $curso = $this->getDoctrine()->getRepository('AppBundle:Curso')->find($id);
        if (!$curso){
            $this->createNotFoundException('Nenhum curso cadastrado com ID: ' . $id);
        }
        if($request->getMethod() == 'POST'){
            if($request->get('del') == 'Sim'){
                $em = $this->getDoctrine()->getManager();
                $em->remove($curso);
                $em->flush();
                $this->addFlash('warning','Curso excluído');
            }
            return $this->redirectToRoute('admin_cursos_index');
        }
        return $this->render('cursos/excluir.html.twig', array('curso' => $curso));
    }

}
<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Curso;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("admin/cursos")
 */
class CursoController extends Controller
{
    /**
     * @Route("/", name="admin_cursos_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $cursos = $em->getRepository('AppBundle:Curso')->findAll();
        return $this->render('admin/curso/index.html.twig', array(
            'cursos' => $cursos,
        ));
    }

    /**
     * @Route("/new", name="admin_cursos_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $curso = new Curso();
        $form = $this->createForm('AppBundle\Form\CursoType', $curso);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($curso);
            $em->flush();
            return $this->redirectToRoute('admin_cursos_show', array('id' => $curso->getId()));
        }
        return $this->render('admin/curso/new.html.twig', array(
            'curso' => $curso,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="admin_cursos_show")
     * @Method("GET")
     */
    public function showAction(Curso $curso)
    {
        $deleteForm = $this->createDeleteForm($curso);
        return $this->render('admin/curso/show.html.twig', array(
            'curso' => $curso,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="admin_cursos_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Curso $curso)
    {
        $deleteForm = $this->createDeleteForm($curso);
        $editForm = $this->createForm('AppBundle\Form\CursoType', $curso);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_cursos_edit', array('id' => $curso->getId()));
        }
        return $this->render('admin/curso/edit.html.twig', array(
            'curso' => $curso,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="admin_cursos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Curso $curso)
    {
        $form = $this->createDeleteForm($curso);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($curso);
            $em->flush();
        }
        return $this->redirectToRoute('admin_cursos_index');
    }

    private function createDeleteForm(Curso $curso)
    {
        return $this
            ->createFormBuilder()
            ->setAction($this->generateUrl('admin_cursos_delete', array('id' => $curso->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}

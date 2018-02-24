<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Departamento;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("admin/departamentos")
 */
class DepartamentoController extends Controller
{
    /**
     * @Route("/", name="admin_departamentos_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $departamentos = $em->getRepository('AppBundle:Departamento')->findAll();
        return $this->render('admin/departamento/index.html.twig', array(
            'departamentos' => $departamentos,
        ));
    }

    /**
     * @Route("/new", name="admin_departamentos_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $departamento = new Departamento();
        $form = $this->createForm('AppBundle\Form\DepartamentoType', $departamento);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($departamento);
            $em->flush();
            return $this->redirectToRoute('admin_departamentos_show', array('id' => $departamento->getId()));
        }
        return $this->render('departamento/new.html.twig', array(
            'departamento' => $departamento,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="admin_departamentos_show")
     * @Method("GET")
     */
    public function showAction(Departamento $departamento)
    {
        $deleteForm = $this->createDeleteForm($departamento);
        return $this->render('departamento/show.html.twig', array(
            'departamento' => $departamento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/{id}/edit", name="admin_departamentos_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Departamento $departamento)
    {
        $deleteForm = $this->createDeleteForm($departamento);
        $editForm = $this->createForm('AppBundle\Form\DepartamentoType', $departamento);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_departamentos_edit', array('id' => $departamento->getId()));
        }
        return $this->render('departamento/edit.html.twig', array(
            'departamento' => $departamento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="admin_departamentos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Departamento $departamento)
    {
        $form = $this->createDeleteForm($departamento);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($departamento);
            $em->flush();
        }
        return $this->redirectToRoute('admin_departamentos_index');
    }

    private function createDeleteForm(Departamento $departamento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_departamentos_delete', array('id' => $departamento->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}

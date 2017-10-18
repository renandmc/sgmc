<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\NivelAcesso;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Nivelacesso controller.
 *
 * @Route("admin/niveisacesso")
 */
class NivelAcessoController extends Controller
{
    /**
     * Lists all nivelAcesso entities.
     *
     * @Route("/", name="admin_niveisacesso_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $nivelAcessos = $em->getRepository('AppBundle:NivelAcesso')->findAll();

        return $this->render('nivelacesso/index.html.twig', array(
            'nivelAcessos' => $nivelAcessos,
        ));
    }

    /**
     * Creates a new nivelAcesso entity.
     *
     * @Route("/new", name="admin_niveisacesso_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $nivelAcesso = new Nivelacesso();
        $form = $this->createForm('AppBundle\Form\NivelAcessoType', $nivelAcesso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($nivelAcesso);
            $em->flush();

            return $this->redirectToRoute('admin_niveisacesso_show', array('id' => $nivelAcesso->getId()));
        }

        return $this->render('nivelacesso/new.html.twig', array(
            'nivelAcesso' => $nivelAcesso,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a nivelAcesso entity.
     *
     * @Route("/{id}", name="admin_niveisacesso_show")
     * @Method("GET")
     */
    public function showAction(NivelAcesso $nivelAcesso)
    {
        $deleteForm = $this->createDeleteForm($nivelAcesso);

        return $this->render('nivelacesso/show.html.twig', array(
            'nivelAcesso' => $nivelAcesso,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing nivelAcesso entity.
     *
     * @Route("/{id}/edit", name="admin_niveisacesso_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, NivelAcesso $nivelAcesso)
    {
        $deleteForm = $this->createDeleteForm($nivelAcesso);
        $editForm = $this->createForm('AppBundle\Form\NivelAcessoType', $nivelAcesso);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_niveisacesso_edit', array('id' => $nivelAcesso->getId()));
        }

        return $this->render('nivelacesso/edit.html.twig', array(
            'nivelAcesso' => $nivelAcesso,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a nivelAcesso entity.
     *
     * @Route("/{id}", name="admin_niveisacesso_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, NivelAcesso $nivelAcesso)
    {
        $form = $this->createDeleteForm($nivelAcesso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($nivelAcesso);
            $em->flush();
        }

        return $this->redirectToRoute('admin_niveisacesso_index');
    }

    /**
     * Creates a form to delete a nivelAcesso entity.
     *
     * @param NivelAcesso $nivelAcesso The nivelAcesso entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(NivelAcesso $nivelAcesso)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_niveisacesso_delete', array('id' => $nivelAcesso->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Equipamento;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Equipamento controller.
 *
 * @Route("admin/equipamento")
 */
class EquipamentoController extends Controller
{
    /**
     * Lists all equipamento entities.
     *
     * @Route("/", name="admin_equipamento_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $equipamentos = $em->getRepository('AppBundle:Equipamento')->findAll();

        return $this->render('equipamento/index.html.twig', array(
            'equipamentos' => $equipamentos,
        ));
    }

    /**
     * Creates a new equipamento entity.
     *
     * @Route("/new", name="admin_equipamento_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $equipamento = new Equipamento();
        $form = $this->createForm('AppBundle\Form\EquipamentoType', $equipamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($equipamento);
            $em->flush();

            return $this->redirectToRoute('admin_equipamento_show', array('id' => $equipamento->getId()));
        }

        return $this->render('equipamento/new.html.twig', array(
            'equipamento' => $equipamento,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a equipamento entity.
     *
     * @Route("/{id}", name="admin_equipamento_show")
     * @Method("GET")
     */
    public function showAction(Equipamento $equipamento)
    {
        $deleteForm = $this->createDeleteForm($equipamento);

        return $this->render('equipamento/show.html.twig', array(
            'equipamento' => $equipamento,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing equipamento entity.
     *
     * @Route("/{id}/edit", name="admin_equipamento_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Equipamento $equipamento)
    {
        $deleteForm = $this->createDeleteForm($equipamento);
        $editForm = $this->createForm('AppBundle\Form\EquipamentoType', $equipamento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_equipamento_edit', array('id' => $equipamento->getId()));
        }

        return $this->render('equipamento/edit.html.twig', array(
            'equipamento' => $equipamento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a equipamento entity.
     *
     * @Route("/{id}", name="admin_equipamento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Equipamento $equipamento)
    {
        $form = $this->createDeleteForm($equipamento);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($equipamento);
            $em->flush();
        }

        return $this->redirectToRoute('admin_equipamento_index');
    }

    /**
     * Creates a form to delete a equipamento entity.
     *
     * @param Equipamento $equipamento The equipamento entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Equipamento $equipamento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_equipamento_delete', array('id' => $equipamento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

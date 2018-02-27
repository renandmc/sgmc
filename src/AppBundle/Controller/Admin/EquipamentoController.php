<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Equipamento;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("admin/equipamentos")
 */
class EquipamentoController extends Controller
{
    /**
     * @Route("/", name="admin_equipamentos_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $equipamentos = $em->getRepository('AppBundle:Equipamento')->findAll();
        return $this->render('admin/equipamento/index.html.twig', array(
            'equipamentos' => $equipamentos,
        ));
    }

    /**
     * @Route("/new", name="admin_equipamentos_new")
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
            return $this->redirectToRoute('admin_equipamentos_show', array('id' => $equipamento->getId()));
        }
        return $this->render('equipamento/new.html.twig', array(
            'equipamento' => $equipamento,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="admin_equipamentos_show")
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
     * @Route("/{id}/edit", name="admin_equipamentos_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Equipamento $equipamento)
    {
        $deleteForm = $this->createDeleteForm($equipamento);
        $editForm = $this->createForm('AppBundle\Form\EquipamentoType', $equipamento);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_equipamentos_edit', array('id' => $equipamento->getId()));
        }

        return $this->render('equipamento/edit.html.twig', array(
            'equipamento' => $equipamento,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="admin_equipamentos_delete")
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

        return $this->redirectToRoute('admin_equipamentos_index');
    }

    private function createDeleteForm(Equipamento $equipamento)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_equipamentos_delete', array('id' => $equipamento->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

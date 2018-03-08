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
        return $this->render('admin/equipamento/index.html.twig', array('equipamentos' => $equipamentos));
    }

    /**
     * @Route("/novo", name="admin_equipamentos_novo")
     * @Method({"GET", "POST"})
     */
    public function novoAction(Request $request)
    {
        $equipamento = new Equipamento();
        $form = $this->createForm('AppBundle\Form\EquipamentoType', $equipamento);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($equipamento);
            $em->flush();
            return $this->redirectToRoute('admin_equipamentos_info', array('id' => $equipamento->getId()));
        }
        return $this->render('admin/equipamento/novo.html.twig', array('equipamento' => $equipamento, 'form' => $form->createView()));
    }

    /**
     * @Route("/info/{id}", name="admin_equipamentos_info")
     * @Method("GET")
     */
    public function infoAction(Equipamento $equipamento)
    {
        return $this->render('admin/equipamento/info.html.twig', array('equipamento' => $equipamento));
    }

    /**
     * @Route("/editar/{id}", name="admin_equipamentos_editar")
     * @Method({"GET", "POST"})
     */
    public function editarAction(Request $request, Equipamento $equipamento)
    {
        $editForm = $this->createForm('AppBundle\Form\EquipamentoType', $equipamento);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_equipamentos_editar', array('id' => $equipamento->getId()));
        }
        return $this->render('admin/equipamento/editar.html.twig', array('equipamento' => $equipamento, 'form' => $editForm->createView()));
    }

    /**
     * @Route("/excluir/{id}", name="admin_equipamentos_excluir")
     * @Method({"GET", "POST"})
     */
    public function excluirAction(Request $request, Equipamento $equipamento)
    {
        if($request->getMethod() == 'POST'){
            if($request->get('del') == 'Sim'){
                $em = $this->getDoctrine()->getManager();
                $em->remove($equipamento);
                $em->flush();
            }
            return $this->redirectToRoute('admin_equipamentos_index');
        }
        return $this->render('admin/equipamento/excluir.html.twig', array('equipamento' => $equipamento));
    }

}
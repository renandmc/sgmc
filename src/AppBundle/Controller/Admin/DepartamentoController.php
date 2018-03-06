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
        return $this->render('admin/departamento/index.html.twig', array('departamentos' => $departamentos));
    }

    /**
     * @Route("/info/{id}", name="admin_departamentos_info")
     * @Method("GET")
     */
    public function infoAction(Departamento $departamento)
    {
        return $this->render('admin/departamento/info.html.twig', array(
            'departamento' => $departamento
        ));
    }

    /**
     * @Route("/novo", name="admin_departamentos_novo")
     * @Method({"GET", "POST"})
     */
    public function novoAction(Request $request)
    {
        $departamento = new Departamento();
        $form = $this->createForm('AppBundle\Form\DepartamentoType', $departamento);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($departamento);
            $em->flush();
            return $this->redirectToRoute('admin_departamentos_info', array('id' => $departamento->getId()));
        }
        return $this->render('admin/departamento/novo.html.twig', array(
            'departamento' => $departamento,
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/editar/{id}", name="admin_departamentos_editar")
     * @Method({"GET", "POST"})
     */
    public function editarAction(Request $request, Departamento $departamento)
    {
        $editForm = $this->createForm('AppBundle\Form\DepartamentoType', $departamento);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_departamentos_info', array('id' => $departamento->getId()));
        }
        return $this->render('admin/departamento/editar.html.twig', array(
            'departamento' => $departamento,
            'edit_form' => $editForm->createView()
        ));
    }

    /**
     * @Route("/excluir/{id}", name="admin_departamentos_excluir")
     * @Method({"GET", "POST"})
     */
    public function excluirAction(Request $request, Departamento $departamento)
    {
        if($request->getMethod() == 'POST'){
            if($request->get('del') == 'Sim'){
                $em = $this->getDoctrine()->getManager();
                $em->remove($departamento);
                $em->flush();
            }
            return $this->redirectToRoute('admin_departamentos_index');
        }
        return $this->render('admin/departamento/excluir.html.html.twig', array(
            'departamento' => $departamento
        ));
    }

}

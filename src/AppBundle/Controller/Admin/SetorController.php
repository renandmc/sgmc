<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Setor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("admin/setores")
 * TODO: Alterar setor para setor
 */
class SetorController extends Controller
{
    /**
     * @Route("/", name="admin_setores_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $setores = $em->getRepository('AppBundle:Setor')->findAll();
        return $this->render('admin/setor/index.html.twig', array('setores' => $setores));
    }

    /**
     * @Route("/info/{id}", name="admin_setores_info")
     */
    public function infoAction(Setor $setor)
    {
        return $this->render('admin/setor/info.html.twig', array('setor' => $setor));
    }

    /**
     * @Route("/novo", name="admin_setores_novo")
     */
    public function novoAction(Request $request)
    {
        $setor = new Setor();
        $form = $this->createForm('AppBundle\Form\SetorType', $setor);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($setor);
            $em->flush();
            return $this->redirectToRoute('admin_setores_info', array('id' => $setor->getId()));
        }
        return $this->render('admin/setor/novo.html.twig', array('setor' => $setor, 'form' => $form->createView()));
    }

    /**
     * @Route("/editar/{id}", name="admin_setores_editar")
     */
    public function editarAction(Request $request, Setor $setor)
    {
        $editForm = $this->createForm('AppBundle\Form\SetorType', $setor);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_setores_info', array('id' => $setor->getId()));
        }
        return $this->render('admin/setor/editar.html.twig', array('setor' => $setor, 'form' => $editForm->createView()));
    }

    /**
     * @Route("/excluir/{id}", name="admin_setores_excluir")
     */
    public function excluirAction(Request $request, Setor $setor)
    {
        if($request->getMethod() == 'POST'){
            if($request->get('del') == 'Sim'){
                $em = $this->getDoctrine()->getManager();
                $em->remove($setor);
                $em->flush();
            }
            return $this->redirectToRoute('admin_setores_index');
        }
        return $this->render('admin/setor/excluir.html.twig', array('setor' => $setor));
    }

}

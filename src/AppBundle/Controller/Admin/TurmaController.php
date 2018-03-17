<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Turma;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("admin/turmas")
 */
class TurmaController extends Controller
{
    /**
     * @Route("/", name="admin_turmas_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $turmas = $em->getRepository('AppBundle:Turma')->findAll();
        return $this->render('admin/turma/index.html.twig', array('turmas' => $turmas));
    }

    /**
     * @Route("/info/{id}", name="admin_turmas_info")
     * @Method("GET")
     */
    public function infoAction(Turma $turma)
    {
        return $this->render('turma/show.html.twig', array('turma' => $turma));
    }

    /**
     * @Route("/novo", name="admin_turmas_novo")
     * @Method({"GET", "POST"})
     */
    public function novoAction(Request $request)
    {
        $turma = new Turma();
        $form = $this->createForm('AppBundle\Form\TurmaType', $turma);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($turma);
            $em->flush();
            $this->addFlash('success','Turma criada');
            return $this->redirectToRoute('admin_turmas_index');
        }
        return $this->render('admin/turma/novo.html.twig', array('turma' => $turma, 'form' => $form->createView()));
    }



    /**
     * @Route("/editar/{id}", name="admin_turmas_editar")
     * @Method({"GET", "POST"})
     */
    public function editarAction(Request $request, Turma $turma)
    {
        $editForm = $this->createForm('AppBundle\Form\TurmaType', $turma);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','Turma editada');
            return $this->redirectToRoute('admin_turmas_index');
        }
        return $this->render('admin/turma/editar.html.twig', array('turma' => $turma, 'form' => $editForm->createView()));
    }

    /**
     * @Route("/excluir/{id}", name="admin_turmas_excluir")
     * @Method({"GET", "POST"})
     */
    public function excluirAction(Request $request, Turma $turma)
    {
        if($request->getMethod() == 'POST'){
            if($request->get('del') == 'Sim'){
                $em = $this->getDoctrine()->getManager();
                $em->remove($turma);
                $em->flush();
                $this->addFlash('warning','Turma excluída');
            }else{
                $this->addFlash('success','Nenhuma turma excluída');
            }
            return $this->redirectToRoute('admin_turmas_index');
        }
        return $this->render('admin/turma/excluir.html.twig', array('turma' => $turma));
    }

}
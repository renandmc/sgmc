<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Turma;
use AppBundle\Form\TurmaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TurmaController
 * @package AppBundle\Controller\Admin
 *
 * @Route("admin/turmas")
 */
class TurmaController extends Controller
{
    /**
     * Action indexAction
     * @return Response
     *
     * @Route("/", name="admin_turmas_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $turmas = $em->getRepository('AppBundle:Turma')->findAll();
        return $this->render('admin/turma/index.html.twig', array('turmas' => $turmas));
    }

    /**
     * Action infoAction
     * @param Turma $turma
     * @return Response
     *
     * @Route("/info/{id}", name="admin_turmas_info")
     */
    public function infoAction(Turma $turma)
    {
        return $this->render('turma/show.html.twig', array('turma' => $turma));
    }

    /**
     * Action novoAction
     * @param Request $request
     * @return RedirectResponse|Response
     *
     * @Route("/novo", name="admin_turmas_novo")
     */
    public function novoAction(Request $request)
    {
        $turma = new Turma();
        $form = $this->createForm(TurmaType::class, $turma);
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
     * Action editarAction
     * @param Request $request
     * @param Turma $turma
     * @return RedirectResponse|Response
     *
     * @Route("/editar/{id}", name="admin_turmas_editar")
     */
    public function editarAction(Request $request, Turma $turma)
    {
        $editForm = $this->createForm(TurmaType::class, $turma);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','Turma editada');
            return $this->redirectToRoute('admin_turmas_index');
        }
        return $this->render('admin/turma/editar.html.twig', array('turma' => $turma, 'form' => $editForm->createView()));
    }

    /**
     * Action excluirAction
     * @param Request $request
     * @param Turma $turma
     * @return RedirectResponse|Response
     *
     * @Route("/excluir/{id}", name="admin_turmas_excluir")
     */
    public function excluirAction(Request $request, Turma $turma)
    {
        if($request->getMethod() == 'POST'){
            if($request->get('del') == 'Sim'){
                $em = $this->getDoctrine()->getManager();
                $em->remove($turma);
                $em->flush();
                $this->addFlash('warning','Turma excluída');
            }
            return $this->redirectToRoute('admin_turmas_index');
        }
        return $this->render('admin/turma/excluir.html.twig', array('turma' => $turma));
    }
}
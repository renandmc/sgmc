<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Setor;
use AppBundle\Form\SetorType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SetorController
 * @package AppBundle\Controller\Admin
 *
 * @Route("admin/setores")
 */
class SetorController extends Controller
{

    /**
     * Action indexAction
     * @return Response
     *
     * @Route("/", name="admin_setores_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $setores = $em->getRepository('AppBundle:Setor')->findAll();
        return $this->render('setores/index.html.twig', array('setores' => $setores));
    }

    /**
     * Action infoAction
     * @param int $id
     * @return Response
     *
     * @Route("/info/{id}", name="admin_setores_info")
     */
    public function infoAction($id)
    {
        $setor = $this->getDoctrine()->getRepository('AppBundle:Setor')->find($id);
        if (!$setor){
            $this->createNotFoundException("Nenhum setor cadastrado com ID: $id");
        }
        return $this->render('setores/info.html.twig', array('setor' => $setor));
    }

    /**
     * Action novoAction
     * @param Request $request
     * @return RedirectResponse|Response
     *
     * @Route("/novo", name="admin_setores_novo")
     */
    public function novoAction(Request $request)
    {
        $setor = new Setor();
        $form = $this->createForm(SetorType::class, $setor);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($setor);
            $em->flush();
            $this->addFlash('success','Setor criado');
            return $this->redirectToRoute('admin_setores_info', array('id' => $setor->getId()));
        }
        return $this->render('setores/novo.html.twig', array('setor' => $setor, 'form' => $form->createView()));
    }

    /**
     * Action editarAction
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     *
     * @Route("/editar/{id}", name="admin_setores_editar")
     */
    public function editarAction(Request $request, $id)
    {
        $setor = $this->getDoctrine()->getRepository('AppBundle:Setor')->find($id);
        if (!$setor){
            $this->createNotFoundException("Nenhum setor cadastrado com ID: $id");
        }
        $form = $this->createForm(SetorType::class, $setor);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Setor atualizado');
            return $this->redirectToRoute('admin_setores_info', array('id' => $setor->getId()));
        }
        return $this->render('setores/editar.html.twig', array('setor' => $setor, 'form' => $form->createView()));
    }

    /**
     * Action excluirAction
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     *
     * @Route("/excluir/{id}", name="admin_setores_excluir")
     */
    public function excluirAction(Request $request, $id)
    {
        $setor = $this->getDoctrine()->getRepository('AppBundle:Setor')->find($id);
        if (!$setor){
           $this->createNotFoundException("Nenhum setor cadastrado com ID: $id");
        }
        if ($request->getMethod() == 'POST'){
            if ($request->get('del') == 'Sim'){
                $em = $this->getDoctrine()->getManager();
                $em->remove($setor);
                $em->flush();
                $this->addFlash('success','Setor excluído');
            }
            return $this->redirectToRoute('admin_setores_index');
        }
        return $this->render('setores/excluir.html.twig', array('setor' => $setor));
    }

}
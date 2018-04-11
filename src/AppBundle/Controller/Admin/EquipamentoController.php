<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Equipamento;
use AppBundle\Form\EquipamentoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EquipamentoController
 * @package AppBundle\Controller\Admin
 *
 * @Route("admin/equipamentos")
 */
class EquipamentoController extends Controller
{
    /**
     * Action indexAction
     * @return Response
     *
     * @Route("/", name="admin_equipamentos_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $equipamentos = $em->getRepository('AppBundle:Equipamento')->findAll();
        return $this->render('admin/equipamento/index.html.twig', array('equipamentos' => $equipamentos));
    }

    /**
     * Action novoAction
     * @param Request $request
     * @return RedirectResponse|Response
     *
     * @Route("/novo", name="admin_equipamentos_novo")
     */
    public function novoAction(Request $request)
    {
        $equipamento = new Equipamento();
        $form = $this->createForm(EquipamentoType::class, $equipamento);
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
     * Action infoAction
     * @param Equipamento $equipamento
     * @return Response
     *
     * @Route("/info/{id}", name="admin_equipamentos_info")
     */
    public function infoAction(Equipamento $equipamento)
    {
        return $this->render('admin/equipamento/info.html.twig', array('equipamento' => $equipamento));
    }

    /**
     * Action editarAction
     * @param Request $request
     * @param Equipamento $equipamento
     * @return RedirectResponse|Response
     *
     * @Route("/editar/{id}", name="admin_equipamentos_editar")
     */
    public function editarAction(Request $request, Equipamento $equipamento)
    {
        $editForm = $this->createForm(EquipamentoType::class, $equipamento);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_equipamentos_editar', array('id' => $equipamento->getId()));
        }
        return $this->render('admin/equipamento/editar.html.twig', array('equipamento' => $equipamento, 'form' => $editForm->createView()));
    }

    /**
     * Action excluirAction
     * @param Request $request
     * @param Equipamento $equipamento
     * @return RedirectResponse|Response
     *
     * @Route("/excluir/{id}", name="admin_equipamentos_excluir")
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
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
        return $this->render('equipamentos/index.html.twig', array('equipamentos' => $equipamentos));
    }

    /**
     * Action infoAction
     * @param int $id
     * @return Response
     *
     * @Route("/info/{id}", name="admin_equipamentos_info")
     */
    public function infoAction($id)
    {
        $equipamento = $this->getDoctrine()->getRepository('AppBundle:Equipamento')->find($id);
        if(!$equipamento){
            $this->createNotFoundException("Nenhum equipamento cadastrado com ID: $id");
        }
        return $this->render('equipamentos/info.html.twig', array('equipamento' => $equipamento));
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
        return $this->render('equipamentos/novo.html.twig', array('equipamento' => $equipamento, 'form' => $form->createView()));
    }

    /**
     * Action editarAction
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     *
     * @Route("/editar/{id}", name="admin_equipamentos_editar")
     */
    public function editarAction(Request $request, $id)
    {
        $equipamento = $this->getDoctrine()->getRepository('AppBundle:Equipamento')->find($id);
        if(!$equipamento){
            $this->createNotFoundException("Nenhum equipamento cadastrado com ID: $id");
        }
        $form = $this->createForm(EquipamentoType::class, $equipamento);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('admin_equipamentos_editar', array('id' => $equipamento->getId()));
        }
        return $this->render('equipamentos/editar.html.twig', array('equipamento' => $equipamento, 'form' => $form->createView()));
    }

    /**
     * Action excluirAction
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     *
     * @Route("/excluir/{id}", name="admin_equipamentos_excluir")
     */
    public function excluirAction(Request $request, $id)
    {
        $equipamento = $this->getDoctrine()->getRepository('AppBundle:Equipamento')->find($id);
        if(!$equipamento){
            $this->createNotFoundException("Nenhum equipamento registrado com ID: $id");
        }
        if($request->getMethod() == 'POST'){
            if($request->get('del') == 'Sim'){
                $em = $this->getDoctrine()->getManager();
                $em->remove($equipamento);
                $em->flush();
            }
            return $this->redirectToRoute('admin_equipamentos_index');
        }
        return $this->render('equipamentos/excluir.html.twig', array('equipamento' => $equipamento));
    }

}
<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Equipamento;
use AppBundle\Entity\Ordem;
use AppBundle\Form\OrdemType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class OrdemController
 * @package AppBundle\Controller\Admin
 *
 * @Route("admin/ordens")
 */
class OrdemController extends Controller
{
    /**
     * Action indexAction
     * @return Response
     *
     * @Route("/", name="admin_ordens_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ordens = $em->getRepository('AppBundle:Ordem')->findAll();
        return $this->render('admin/ordem/index.html.twig', array('ordens' => $ordens));
    }

    /**
     * Action infoAction
     * @return Response
     *
     * @Route("/info/{id}", name="admin_ordens_info")
     */
    public function infoAction(Ordem $ordem)
    {
        return $this->render('admin/ordem/info.html.twig', array('ordem' => $ordem));
    }

    /**
     * Action buscarEsquipamentoAction
     * @return Response
     *
     * @Route("/busca", name="admin_ordens_busca")
     */
    public function buscarEquipamentoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $setores = $em->getRepository('AppBundle:Setor')->findAll();
        return $this->render('admin/ordem/busca.html.twig', array('setores' => $setores));
    }

    /**
     * Action novoAction
     * @param Request $request
     * @param Equipamento $equipamento
     * @return RedirectResponse|Response
     *
     * @Route("/novo/{id}", name="admin_ordens_novo")
     */
    public function novoAction(Request $request, Equipamento $equipamento)
    {
        $ordem = new Ordem();
        $form = $this->createForm(OrdemType::class, $ordem);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $ordem->setEquipamento($equipamento);
            $ordem->setUsuario($this->getUser());
            $em->persist($ordem);
            $em->flush();
            $this->addFlash('success','Ordem criada');
            return $this->redirectToRoute('admin_ordens_index');
        }
        return $this->render('admin/ordem/novo.html.twig', array('ordem' => $ordem, 'equipamento' => $equipamento ,'form' => $form->createView()));
    }

    /**
     * Action editarAction
     * @param Request $request
     * @param Ordem $ordem
     * @return RedirectResponse|Response
     *
     * @Route("/editar/{id}", name="admin_ordens_editar")
     */
    public function editarAction(Request $request, Ordem $ordem)
    {
        $editForm = $this->createForm(OrdemType::class, $ordem);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()){
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Ordem editada');
            return $this->redirectToRoute('admin_ordens_index');
        }
        return $this->render('admin/ordem/editar.html.twig', array('ordem' => $ordem, 'form' => $editForm));
    }

    /**
     * Action fecharAction
     * @param Request $request
     * @param Ordem $ordem
     * @return RedirectResponse|Response
     *
     * @Route("/fechar/{id}", name="admin_ordens_fechar")
     */
    public function fecharAction(Request $request, Ordem $ordem)
    {
        if ($request->getMethod() == 'POST'){
            if ($request->get('fecha') == 'Sim'){
                $ordem->fechaOrdem();
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'Ordem fechada');
                return $this->redirectToRoute('admin_ordens_index');
            }
        }
        return $this->render('admin/ordem/fecha.html.twig', array('ordem' => $ordem));
    }

    /**
     * Action excluirAction
     * @param Request $request
     * @param Ordem $ordem
     * @return RedirectResponse|Response
     *
     * @Route("/excluir/{id}", name="admin_ordens_excluir")
     */
    public function excluirAction(Request $request, Ordem $ordem)
    {
        if($request->getMethod() == 'POST'){
            if($request->get('del') == 'Sim'){
                $em = $this->getDoctrine()->getManager();
                $em->remove($ordem);
                $em->flush();
                $this->addFlash('warning','Ordem excluída');
            }
            return $this->redirectToRoute('admin_ordens_index');
        }
        return $this->render('admin/ordem/excluir.html.twig', array('ordem' => $ordem));
    }
}
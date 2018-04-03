<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Equipamento;
use AppBundle\Entity\Ordem;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("admin/ordens")
 */
class OrdemController extends Controller
{
    /**
     * @Route("/", name="admin_ordens_index")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($this->getUser()->getTipo() == 'Representante'){
            $ordens = $em->getRepository('AppBundle:Ordem')->findBy(array('usuario' => $this->getUser()));
        } else {
            $ordens = $em->getRepository('AppBundle:Ordem')->findAll();
        }
        return $this->render('admin/ordem/index.html.twig', array('ordens' => $ordens));
    }

    /**
     * @Route("/info/{id}", name="admin_ordens_info")
     */
    public function infoAction(Ordem $ordem)
    {
        return $this->render('admin/ordem/info.html.twig', array('ordem' => $ordem));
    }

    /**
     * @Route("/busca", name="admin_ordens_busca")
     */
    public function buscarEquipamentoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $setores = $em->getRepository('AppBundle:Setor')->findAll();
        return $this->render('admin/ordem/busca.html.twig', array('setores' => $setores));
    }

    /**
     * @Route("/novo/{id}", name="admin_ordens_novo")
     */
    public function novoAction(Request $request, Equipamento $equipamento)
    {
        $ordem = new Ordem();
        $form = $this->createForm('AppBundle\Form\OrdemType', $ordem);
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
     * @Route("/editar/{id}", name="admin_ordens_editar")
     */
    public function editarAction(Request $request, Ordem $ordem)
    {
        $editForm = $this->createForm('AppBundle\Form\OrdemType', $ordem);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()){
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Ordem editada');
            return $this->redirectToRoute('admin_ordens_index');
        }
        return $this->render('admin/ordem/editar.html.twig', array('ordem' => $ordem, 'form' => $editForm));
    }

    /**
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
            }else{
                $this->addFlash('success','Nenhuma ordem excluída');
            }
            return $this->redirectToRoute('admin_ordens_index');
        }
        return $this->render('admin/ordem/excluir.html.twig', array('ordem' => $ordem));
    }
}
<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Curso;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route("admin/cursos")
 */
class CursoController extends Controller
{
    /**
     * @Route("/", name="admin_cursos_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $cursos = $em->getRepository('AppBundle:Curso')->findAll();
        return $this->render('admin/curso/index.html.twig', array('cursos' => $cursos));
    }

    /**
     * @Route("/info/{id}", name="admin_cursos_info")
     * @Method("GET")
     */
    public function infoAction(Curso $curso)
    {
        return $this->render('admin/curso/info.html.twig', array('curso' => $curso));
    }

    /**
     * @Route("/novo", name="admin_cursos_novo")
     * @Method({"GET", "POST"})
     */
    public function novoAction(Request $request)
    {
        $curso = new Curso();
        $form = $this->createForm('AppBundle\Form\CursoType', $curso);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($curso);
            $em->flush();
            $this->addFlash('success',"Curso criado");
            return $this->redirectToRoute('admin_cursos_index');
        }
        return $this->render('admin/curso/novo.html.twig', array('curso' => $curso, 'form' => $form->createView()));
    }

    /**
     * @Route("/editar/{id}", name="admin_cursos_editar")
     * @Method({"GET", "POST"})
     */
    public function editarAction(Request $request, Curso $curso)
    {
        $editForm = $this->createForm('AppBundle\Form\CursoType', $curso);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success','Curso editada');
            return $this->redirectToRoute('admin_cursos_index');
        }
        return $this->render('admin/curso/editar.html.twig', array('curso' => $curso, 'form' => $editForm->createView()));
    }

    /**
     * @Route("/excluir/{id}", name="admin_cursos_excluir")
     * @Method({"GET", "POST"})
     */
    public function excluirAction(Request $request, Curso $curso)
    {
        if($request->getMethod() == 'POST'){
            if($request->get('del') == 'Sim'){
                $em = $this->getDoctrine()->getManager();
                $em->remove($curso);
                $em->flush();
                $this->addFlash('warning','Curso excluído');
            }
            return $this->redirectToRoute('admin_cursos_index');
        }
        return $this->render('admin/curso/excluir.html.twig', array('curso' => $curso));
    }

}
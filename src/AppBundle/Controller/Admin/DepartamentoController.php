<?php

namespace AppBundle\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DepartamentoController extends Controller
{
    /**
     * @Route("/admin/departamentos", name="dep_home")
     */
    public function indexAction(Request $request)
    {
        $departamentos = $this->getDoctrine()->getRepository('AppBundle:Departamento')->findAll();
        return $this->render('admin/departamento/index.html.twig', array('departamentos' => $departamentos));
    }
}
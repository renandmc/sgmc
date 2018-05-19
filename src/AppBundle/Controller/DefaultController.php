<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contato;
use AppBundle\Form\ContatoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{

    /**
     * Action indexAction
     * @return Response
     *
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig', array());
    }

    /**
     * @Route("/sobre", name="sobre")
     */
    public function sobreAction()
    {
        return $this->render('default/sobre.html.twig', array());
    }

    /**
     * @return Response
     *
     * @Route("/contato", name="contato")
     */
    public function contatoAction(Request $request)
    {
        $contato = new Contato();
        $form = $this->createForm(ContatoType::class, $contato);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contato);
            $em->flush();
            $this->addFlash('success',"Mensagem enviada");
            return $this->redirectToRoute('sobre');
        }
        return $this->render('default/contato.html.twig', array('contato' => $contato, 'form' => $form->createView()));
    }

}
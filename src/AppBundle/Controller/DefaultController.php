<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FaleConosco;
use AppBundle\Form\FaleConoscoType;
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
     * @Route("/fale_conosco", name="fale_conosco")
     */

    public function FaleConoscoAction(Request $request)
    {
        $faleconosco = new FaleConosco();
        $form = $this->createForm(FaleConoscoType::class, $faleconosco);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($faleconosco);
            $em->flush();
            $this->addFlash('success',"Mensagem enviada");
            return $this->redirectToRoute('sobre');
        }
        return $this->render('default/fale_conosco.html.twig', array('faleconosco' => $faleconosco, 'form' => $form->createView()));
    }
}

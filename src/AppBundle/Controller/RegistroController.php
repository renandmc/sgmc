<?php

namespace AppBundle\Controller;

use AppBundle\Form\UsuarioType;
use AppBundle\Entity\Usuario;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegistroController extends Controller
{
    /**
     * @Route("/registrar", name="usuario_registrar")
     */
    public function registrarAction(Request $request)
    {
        // 1) build the form
        $user = new Usuario();
        $form = $this->createForm(UsuarioType::class, $user);
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // 3) Encode the password (you could also do this via Doctrine listener)
            $encoder = $this->get('security.password_encoder');
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
            //return $this->redirectToRoute('replace_with_some_route');
        }
        return $this->render(
            'registro/registrar.html.twig',
            array('form' => $form->createView())
        );
    }
}
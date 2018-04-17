<?php

namespace AppBundle\Fixtures;

use AppBundle\Entity\Usuario;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsuariosFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $usuarioAdm = new Usuario();
        $senhaAdm = $this->encoder->encodePassword($usuarioAdm, 'admin');
        $usuarioAdm
            ->setUsuario('admin')
            ->setTipo(Usuario::ADMIN)
            ->setSenha($senhaAdm);

        $manager->persist($usuarioAdm);

        $usuarioProf = new Usuario();
        $senhaProf = $this->encoder->encodePassword($usuarioProf, 'professor');
        $usuarioProf
            ->setUsuario('professor')
            ->setTipo(Usuario::PROF)
            ->setSenha($senhaProf);

        $manager->persist($usuarioProf);

        $usuarioRep = new Usuario();
        $senhaRep = $this->encoder->encodePassword($usuarioRep, 'representante');
        $usuarioRep
            ->setUsuario('representante')
            ->setTipo(Usuario::REP)
            ->setSenha($senhaRep);

        $manager->persist($usuarioRep);

        $manager->flush();
    }
}
<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Usuario;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUsuariosData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    private $container;

    public function load(ObjectManager $manager)
    {
        $admin = new Usuario();
        $admin->setUsuario('admin');
        $admin->setTipo(Usuario::ADMIN);
        $admin->setSenha($this->container->get('security.password_encoder')->encodePassword($admin, 'admin'));
        $manager->persist($admin);
        $manager->flush();

        $this->addReference('usuario-admin', $admin);
    }

    public function getOrder()
    {
        return 1;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
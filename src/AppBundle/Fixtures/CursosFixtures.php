<?php

namespace AppBundle\Fixtures;

use AppBundle\Entity\Curso;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CursosFixtures extends Fixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $cursos = array(
            'Ensino médio',
            'Técnico em agropecuária integrado ao ensino médio',
            'Técnico em agroindústria',
            'Técnico em informática para Internet',
            'Técnico em administração',
            'Técnico em açúcar e álcool'
        );
        foreach ($cursos as $nome){
            $curso = new Curso();
            $curso->setNome($nome);
            $manager->persist($curso);
        }
        $manager->flush();
    }
}
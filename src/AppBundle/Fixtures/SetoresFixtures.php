<?php

namespace AppBundle\Fixtures;

use AppBundle\Entity\Setor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SetoresFixtures extends Fixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $setores = array(
            "Biblioteca",
            "Laboratório 01",
            "Laboratório 02",
            "Laboratório 03",
        );
        foreach ($setores as $setor){

        }
    }
}
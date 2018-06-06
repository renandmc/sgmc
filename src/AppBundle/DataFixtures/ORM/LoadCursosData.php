<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Curso;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCursosData extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $ensinoMedio = new Curso();
        $ensinoMedio->setNome("Ensino médio");
        $manager->persist($ensinoMedio);
        $agropecuaria = new Curso();
        $agropecuaria->setNome("Técnico em agropecuária integrado ao ensino médio");
        $manager->persist($agropecuaria);
        $agroindustria = new Curso();
        $agroindustria->setNome("Técnico em agroindústria");
        $manager->persist($agroindustria);
        $info = new Curso();
        $info->setNome("Técnico em informática para Internet");
        $manager->persist($info);
        $infoMedio = new Curso();
        $infoMedio->setNome("Técnico em informática para Internet integrado ao ensino médio");
        $manager->persist($infoMedio);
        $adm = new Curso();
        $adm->setNome("Técnico em administração");
        $manager->persist($adm);
        $acucar = new Curso();
        $acucar->setNome("Técnico em açúcar e álcool");
        $manager->persist($acucar);
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
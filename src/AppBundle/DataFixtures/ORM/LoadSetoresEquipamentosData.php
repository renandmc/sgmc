<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Equipamento;
use AppBundle\Entity\Setor;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Vich\UploaderBundle\Entity\File;

class LoadSetoresEquipamentosData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $setores = ["Biblioteca", "Laboratório 01", "Laboratório 02", "Laboratório 03", "Laboratório 04"];
        $fotoSetor = new File();
        $fotoSetor->setName("setor.jpg");
        $fotoPC = new File();
        $fotoPC->setName("pc.jpg");
        $pcs = ["PC 01", "PC 02", "PC 03"];
        foreach ($setores as $nome){
            $setor = new Setor();
            $setor->setNome($nome)->setImage($fotoSetor)->setUpdatedAt(new \DateTime("now"));
            $manager->persist($setor);
            foreach ($pcs as $nome){
                $pc = new Equipamento();
                $pc->setNome($nome)->setMarca("Positivo")->setModelo("PC")->setDescricao("Celeron, 2 GB memória, 500 GB HD")->setTipoEquipamento("Desktop")->setSetor($setor)->setImage($fotoPC)->setUpdatedAt(new \DateTime("now"));
                $manager->persist($pc);
            }
        }
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }
}
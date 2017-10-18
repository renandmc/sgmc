<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="departamentos")
 * @ORM\Entity()
 */
class Departamento
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="nome", type="string", length=255)
     */
    private $nome;

    /**
     * @ORM\OneToMany(targetEntity="Equipamento", mappedBy="departamento")
     */
    private $equipamentos;

    public function __construct()
    {
        $this->equipamentos = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Add equipamento
     *
     * @param \AppBundle\Entity\Equipamento $equipamento
     *
     * @return Departamento
     */
    public function addEquipamento(\AppBundle\Entity\Equipamento $equipamento)
    {
        $this->equipamentos[] = $equipamento;

        return $this;
    }

    /**
     * Remove equipamento
     *
     * @param \AppBundle\Entity\Equipamento $equipamento
     */
    public function removeEquipamento(\AppBundle\Entity\Equipamento $equipamento)
    {
        $this->equipamentos->removeElement($equipamento);
    }

    /**
     * Get equipamentos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEquipamentos()
    {
        return $this->equipamentos;
    }
}

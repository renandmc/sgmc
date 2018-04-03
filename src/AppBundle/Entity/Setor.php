<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="setores")
 * @ORM\Entity()
 */
class Setor
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="nome", type="string", length=255)
     */
    private $nome;

    /**
     * @ORM\Column(name="foto", type="string")
     * @Assert\NotBlank(message="Envie a foto do setor")
     * @Assert\File(mimeTypes={})
     */
    private $foto;

    /**
     * @ORM\OneToMany(targetEntity="Equipamento", mappedBy="setor")
     */
    private $equipamentos;

    public function __construct()
    {
        $this->equipamentos = new ArrayCollection();
    }

    public function __toString()
    {
        return "$this->nome";
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function getEquipamentos()
    {
        return $this->equipamentos;
    }

    public function addEquipamento(Equipamento $equipamento)
    {
        $this->equipamentos[] = $equipamento;
        return $this;
    }

    public function removeEquipamento(Equipamento $equipamento)
    {
        $this->equipamentos->removeElement($equipamento);
    }
}
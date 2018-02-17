<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="ordens")
 * @ORM\Entity()
 */
class Ordem
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="data", type="datetime")
     */
    private $data;

    /**
     * @ORM\Column(name="descricao", type="string", length=200)
     */
    private $descricao;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Equipamento", inversedBy="ordens")
     * @ORM\JoinColumn(name="equipamento_id", referencedColumnName="id")
     */
    private $equipamento;

    public function getId()
    {
        return $this->id;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function getEquipamento()
    {
        return $this->equipamento;
    }

    public function setEquipamento(Equipamento $equipamento = null)
    {
        $this->equipamento = $equipamento;
        return $this;
    }
}
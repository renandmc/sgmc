<?php

namespace AppBundle\Entity;

use DateTime;
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Equipamento", inversedBy="ordens")
     * @ORM\JoinColumn(name="equipamento_id", referencedColumnName="id")
     */
    private $equipamento;

    /**
     * @ORM\Column(name="descricao", type="string", length=200)
     */
    private $descricao;

    /**
     * @ORM\Column(name="data", type="datetime")
     */
    private $data;

    /**
     * @ORM\Column(name="status", type="string", length=30)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario")
     * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     */
    private $usuario;

    public function __construct()
    {
        $this->data = new DateTime('now');
        $this->status = "Aberto";
    }

    public function __toString()
    {
        return $this->descricao;
    }

    public function getId()
    {
        return $this->id;
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

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
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

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setUsuario(Usuario $usuario = null)
    {
        $this->usuario = $usuario;
        return $this;
    }
}
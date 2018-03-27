<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="equipamentos")
 * @ORM\Entity()
 */
class Equipamento
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="num_maquina", type="integer")
     */
    private $numero;

    /**
     * @ORM\Column(name="tipo_equipamento", type="string", length=100)
     */
    private $tipoEquipamento;

    /**
     * @ORM\Column(name="marca", type="string", length=100)
     */
    private $marca;

    /**
     * @ORM\Column(name="modelo", type="string", length=100)
     */
    private $modelo;

    /**
     * @ORM\Column(name="descricao", type="string", length=200)
     */
    private $descricao;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Departamento", inversedBy="equipamentos")
     * @ORM\JoinColumn(name="departamento_id", referencedColumnName="id")
     */
    private $departamento;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Ordem", mappedBy="equipamento")
     */
    private $ordens;

    /**
     * @ORM\Column(name="status", type="string", length=50)
     */
    private $status;

    public function __construct()
    {
        $this->ordens = new ArrayCollection();
        $this->status = "Em funcionamento";
    }

    public function __toString()
    {
        return $this->tipoEquipamento . ' ' . $this->modelo . ' ' . $this->marca;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;
        return $this;
    }

    public function getTipoEquipamento()
    {
        return $this->tipoEquipamento;
    }

    public function setTipoEquipamento($tipoEquipamento)
    {
        $this->tipoEquipamento = $tipoEquipamento;
        return $this;
    }

    public function getMarca()
    {
        return $this->marca;
    }

    public function setMarca($marca)
    {
        $this->marca = $marca;
        return $this;
    }

    public function getModelo()
    {
        return $this->modelo;
    }

    public function setModelo($modelo)
    {
        $this->modelo = $modelo;
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

    public function getDepartamento()
    {
        return $this->departamento;
    }

    public function setDepartamento(Departamento $departamento = null)
    {
        $this->departamento = $departamento;
        return $this;
    }

    public function getOrdens()
    {
        return $this->ordens;
    }

    public function addOrdem(Ordem $ordem = null)
    {
        $this->ordens[] = $ordem;
        return $this;
    }

    public function removeOrdem(Ordem $ordem)
    {
        $this->ordens->removeElement($ordem);
    }

    public function getEquipamento()
    {
        return $this->tipoEquipamento . ' ' . $this->marca . ' ' . $this->modelo;
    }

}

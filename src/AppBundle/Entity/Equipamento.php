<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Departamento;
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
     * @ORM\Column(name="descricao", type="string", length=255)
     */
    private $descricao;

    /**
     * @ORM\Column(name="marca", type="string", length=255)
     */
    private $marca;

    /**
     * @ORM\Column(name="modelo", type="string", length=255)
     */
    private $modelo;

    /**
     * @ORM\Column(name="num_maquina", type="integer")
     */
    private $numMaquina;

    /**
     * @ORM\ManyToOne(targetEntity="Departamento", inversedBy="equipamentos")
     * @ORM\JoinColumn(name="departamento_id", referencedColumnName="id")
     */
    private $departamento;

    public function getId()
    {
        return $this->id;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setMarca($marca)
    {
        $this->marca = $marca;

        return $this;
    }

    public function getMarca()
    {
        return $this->marca;
    }

    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    public function getModelo()
    {
        return $this->modelo;
    }

    public function setNumMaquina($numMaquina)
    {
        $this->numMaquina = $numMaquina;

        return $this;
    }

    public function getNumMaquina()
    {
        return $this->numMaquina;
    }

    public function setDepartamento(Departamento $departamento = null)
    {
        $this->departamento = $departamento;

        return $this;
    }

    public function getDepartamento()
    {
        return $this->departamento;
    }
}

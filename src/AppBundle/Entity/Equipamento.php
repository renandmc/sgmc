<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipamento
 *
 * @ORM\Table(name="equipamentos")
 * @ORM\Entity()
 */
class Equipamento
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="descricao", type="string", length=255)
     */
    private $descricao;

    /**
     * @var string
     *
     * @ORM\Column(name="marca", type="string", length=255)
     */
    private $marca;

    /**
     * @var string
     *
     * @ORM\Column(name="modelo", type="string", length=255)
     */
    private $modelo;

    /**
     * @var int
     *
     * @ORM\Column(name="num_maquina", type="integer")
     */
    private $numMaquina;

    /**
     * @ORM\ManyToOne(targetEntity="Departamento", inversedBy="equipamentos")
     * @ORM\JoinColumn(name="departamento_id", referencedColumnName="id")
     */
    private $departamento;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     *
     * @return Equipamento
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;

        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set marca
     *
     * @param string $marca
     *
     * @return Equipamento
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;

        return $this;
    }

    /**
     * Get marca
     *
     * @return string
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Set modelo
     *
     * @param string $modelo
     *
     * @return Equipamento
     */
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get modelo
     *
     * @return string
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set numMaquina
     *
     * @param int $numMaquina
     *
     * @return Equipamento
     */
    public function setNumMaquina($numMaquina)
    {
        $this->numMaquina = $numMaquina;

        return $this;
    }

    /**
     * Get numMaquina
     *
     * @return int
     */
    public function getNumMaquina()
    {
        return $this->numMaquina;
    }

    /**
     * Set departamento
     *
     * @param \AppBundle\Entity\Departamento $departamento
     *
     * @return Equipamento
     */
    public function setDepartamento(\AppBundle\Entity\Departamento $departamento = null)
    {
        $this->departamento = $departamento;

        return $this;
    }

    /**
     * Get departamento
     *
     * @return \AppBundle\Entity\Departamento
     */
    public function getDepartamento()
    {
        return $this->departamento;
    }
}

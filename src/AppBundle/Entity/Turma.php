<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="turmas")
 */
class Turma
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Curso", inversedBy="turmas")
     */
    private $curso;

    /**
     * @ORM\Column(name="modulo", type="string")
     */
    private $modulo;

    /**
     * @ORM\Column(name="turno", type="string")
     */
    private $turno;

    /**
     * @ORM\Column(name="ano", type="datetime", nullable=true)
     */
    private $ano;

    public function getId()
    {
        return $this->id;
    }

    public function getCurso()
    {
        return $this->curso;
    }

    public function setCurso(Curso $curso = null)
    {
        $this->curso = $curso;
        return $this;
    }

    public function getModulo()
    {
        return $this->modulo;
    }

    public function setModulo($modulo)
    {
        $this->modulo = $modulo;
        return $this;
    }

    public function getTurno()
    {
        return $this->turno;
    }

    public function setTurno($turno)
    {
        $this->turno = $turno;
        return $this;
    }

    public function getAno()
    {
        return $this->ano;
    }

    public function setAno($ano)
    {
        $this->ano = $ano;
        return $this;
    }

}
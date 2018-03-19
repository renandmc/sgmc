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
     * @ORM\Column(name="periodo", type="string")
     */
    private $periodo;

    /**
     * @ORM\Column(name="turno", type="string")
     */
    private $turno;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Curso", inversedBy="turmas")
     */
    private $curso;


    public function getId()
    {
        return $this->id;
    }

    public function getPeriodo()
    {
        return $this->periodo;
    }

    public function setPeriodo($periodo)
    {
        $this->periodo = $periodo;
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

    public function getCurso()
    {
        return $this->curso;
    }

    public function setCurso(Curso $curso = null)
    {
        $this->curso = $curso;
        return $this;
    }

}
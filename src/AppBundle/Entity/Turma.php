<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Turma
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="turmas")
 */
class Turma
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Curso
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Curso", inversedBy="turmas")
     */
    private $curso;

    /**
     * @var string
     *
     * @ORM\Column(name="modulo", type="string", length=20)
     */
    private $modulo;

    /**
     * @var string
     *
     * @ORM\Column(name="turno", type="string", length=30)
     */
    private $turno;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="ano", type="datetime", nullable=true)
     */
    private $ano;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Curso
     */
    public function getCurso()
    {
        return $this->curso;
    }

    /**
     * @param Curso|null $curso
     * @return Turma
     */
    public function setCurso(Curso $curso = null)
    {
        $this->curso = $curso;
        return $this;
    }

    /**
     * @return string
     */
    public function getModulo()
    {
        return $this->modulo;
    }

    /**
     * @param string $modulo
     * @return Turma
     */
    public function setModulo($modulo)
    {
        $this->modulo = $modulo;
        return $this;
    }

    /**
     * @return string
     */
    public function getTurno()
    {
        return $this->turno;
    }

    /**
     * @param string $turno
     * @return Turma
     */
    public function setTurno($turno)
    {
        $this->turno = $turno;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getAno()
    {
        return $this->ano;
    }

    /**
     * @param DateTime $ano
     * @return Turma
     */
    public function setAno(DateTime $ano)
    {
        $this->ano = $ano;
        return $this;
    }

}
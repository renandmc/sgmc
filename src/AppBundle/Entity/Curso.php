<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="cursos")
 */
class Curso
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $nome;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $descricao;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Turma", mappedBy="curso")
     */
    private $turmas;

    public function __construct()
    {
        $this->turmas = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nome;
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

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function getTurmas()
    {
        return $this->turmas;
    }

    public function addTurma(Turma $turma = null)
    {
        $this->turmas[] = $turma;
        return $this;
    }

    public function removeTurma(Turma $turma)
    {
        $this->turmas->removeElement($turma);
    }
}
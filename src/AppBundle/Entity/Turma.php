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
     * @ORM\Column(name="nome", type="string")
     */
    private $nome;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Curso", inversedBy="turmas")
     */
    private $curso;


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
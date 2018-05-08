<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Curso
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="cursos")
 * @UniqueEntity(fields="nome", message="Nome já utilizado")
 */
class Curso
{

    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nome", type="string", length=150, unique=true)
     * @Assert\NotBlank(message="Preencha o nome")
     */
    private $nome;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Turma", mappedBy="curso")
     */
    private $turmas;

    /**
     * Curso constructor.
     */
    public function __construct()
    {
        $this->turmas = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->nome;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     * @return Curso
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTurmas()
    {
        return $this->turmas;
    }

    /**
     * @param Turma|null $turma
     * @return Curso
     */
    public function addTurma(Turma $turma = null)
    {
        $this->turmas[] = $turma;
        return $this;
    }

    /**
     * @param Turma $turma
     */
    public function removeTurma(Turma $turma)
    {
        $this->turmas->removeElement($turma);
    }

}
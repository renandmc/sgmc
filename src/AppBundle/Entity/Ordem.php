<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="ordens")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrdemRepository")
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
     * @ORM\Column(name="data", type="datetime")
     */
    private $data;

    /**
     * @ORM\Column(name="descricao", type="string", length=200)
     */
    private $descricao;

    public function getId()
    {
        return $this->id;
    }

    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function getData()
    {
        return $this->data;
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
}
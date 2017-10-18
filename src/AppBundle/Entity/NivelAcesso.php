<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NivelAcesso
 *
 * @ORM\Table(name="niveis_acesso")
 * @ORM\Entity()
 */
class NivelAcesso
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
     * @ORM\Column(name="nome", type="string", length=255)
     */
    private $nome;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="criado", type="datetime")
     */
    private $criado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modificado", type="datetime")
     */
    private $modificado;


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
     * Set nome
     *
     * @param string $nome
     *
     * @return NivelAcesso
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set criado
     *
     * @param \DateTime $criado
     *
     * @return NivelAcesso
     */
    public function setCriado($criado)
    {
        $this->criado = $criado;

        return $this;
    }

    /**
     * Get criado
     *
     * @return \DateTime
     */
    public function getCriado()
    {
        return $this->criado;
    }

    /**
     * Set modificado
     *
     * @param \DateTime $modificado
     *
     * @return NivelAcesso
     */
    public function setModificado($modificado)
    {
        $this->modificado = $modificado;

        return $this;
    }

    /**
     * Get modificado
     *
     * @return \DateTime
     */
    public function getModificado()
    {
        return $this->modificado;
    }
}

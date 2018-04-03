<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuarios")
 * @UniqueEntity(fields="email", message="E-mail já utilizado")
 * @UniqueEntity(fields="username", message="Usuário já utilizado")
 */
class Usuario extends BaseUser
{

    const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="tipo", type="string")
     */
    private $tipo;

    public function __toString()
    {
        return "$this->username ($this->email)";
    }

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
        return $this;
    }

    public function setAdmin($boolean)
    {
        if (true === $boolean){
            $this->addRole(static::ROLE_ADMIN);
        } else {
            $this->removeRole(static::ROLE_ADMIN);
        }
    }

    public function isAdmin()
    {
        return $this->hasRole(static::ROLE_ADMIN);
    }
}
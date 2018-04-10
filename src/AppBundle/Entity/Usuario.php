<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="usuarios")
 * @ORM\Entity()
 * @UniqueEntity(fields="email", message="E-mail já cadastrado")
 * @UniqueEntity(fields="usuario", message="Usuário já cadastrado")
 */
class Usuario implements UserInterface, \Serializable
{

    const ROLE_DEFAULT = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    const ADMIN = 'Administrador';
    const PROF = 'Professor';
    const REP = 'Representante';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="usuario", type="string", length=25, unique=true)
     * @Assert\NotBlank()
     */
    private $usuario;

    /**
     * @ORM\Column(name="senha", type="string", length=64)
     */
    private $senha;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=5, max=4096, minMessage="A senha deve ter pelo menos 5 caracteres")
     */
    private $senhaLimpa;

    /**
     * @ORM\Column(name="email", type="string", length=60, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(name="tipo", type="string", length=30)
     */
    private $tipo;

    /**
     * @ORM\Column(name="roles", type="array")
     */
    private $roles;

    public function __construct()
    {
        $this->roles = array();
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->usuario;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->senha;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param string $usuario
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * @return string
     */
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * @param string $senha
     */
    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    /**
     * @return string
     */
    public function getSenhaLimpa()
    {
        return $this->senhaLimpa;
    }

    /**
     * @param string $senhaLimpa
     */
    public function setSenhaLimpa($senhaLimpa)
    {
        $this->senhaLimpa = $senhaLimpa;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param string $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->usuario,
            $this->senha,
            $this->email,
            $this->tipo
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->usuario,
            $this->senha,
            $this->email,
            $this->tipo
            ) = unserialize($serialized);
    }

    public function eraseCredentials()
    {
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        $roles = $this->roles;
        $roles[] = static::ROLE_DEFAULT;
        return array_unique($roles);
    }

    /**
     * @return null|string|void
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @param string $role
     * @return Usuario
     */
    public function addRole($role)
    {
        $role = strtoupper($role);
        if ($role === static::ROLE_DEFAULT){
            return $this;
        }
        if (!in_array($role, $this->roles, true)){
            $this->roles[] = $role;
        }
        return $this;
    }

    /**
     * @param string $role
     * @return Usuario
     */
    public function removeRole($role)
    {
        if (false !== $key = array_search(strtoupper($role), $this->roles, true)){
            unset($this->roles[$key]);
            $this->roles = array_values($this->roles);
        }
        return $this;
    }

    /**
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return in_array(strtoupper($role), $this->roles, true);
    }

    /**
     * @return bool
     */
    public function isUser()
    {
        return $this->hasRole(static::ROLE_DEFAULT);
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->hasRole(static::ROLE_ADMIN);
    }

    /**
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->hasRole(static::ROLE_SUPER_ADMIN);
    }

}
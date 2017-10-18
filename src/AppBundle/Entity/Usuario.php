<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Entidade usuário
 *
 * @ORM\Entity()
 * @ORM\Table(name="usuarios")
 */
class Usuario extends BaseUser
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

	/**
	 * Usuario constructor.
	 */
	public function __construct()
    {
	    parent::__construct();
    }
}

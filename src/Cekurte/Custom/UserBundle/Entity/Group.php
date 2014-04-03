<?php

namespace Cekurte\Custom\UserBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use FOS\UserBundle\Model\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="auth_group")
 */
class Group extends BaseGroup
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Cekurte\Custom\UserBundle\Entity\User", mappedBy="groups")
     */
    private $users;

    /**
     * {@inherited}
     */
    public function __construct($name, $roles = array())
    {
        parent::__construct($name, $roles);

        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the users.
     *
     * @return Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Get User names
     *
     * @return array|null
     */
    public function getUserNames()
    {
        $names = array();
        foreach ($this->getUsers() as $user) {
            $names[] = $user->getName();
        }

        return $names;
    }

    /**
     * Has User
     *
     * @param string $name
     * @return boolean
     */
    public function hasUser($name)
    {
        return in_array($name, $this->getUserNames());
    }

    /**
     * Add a user to group
     *
     * @param UserInterface $user
     * @return Group
     */
    public function addUser(UserInterface $user)
    {
        if (!$this->getUsers()->contains($user)) {
            $this->getUsers()->add($user);
        }

        return $this;
    }

    /**
     * Remove a user from group
     *
     * @param UserInterface $user
     * @return Group
     */
    public function removeUser(UserInterface $user)
    {
        if ($this->getUsers()->contains($user)) {
            $this->getUsers()->removeElement($user);
        }

        return $this;
    }
}

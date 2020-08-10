<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\BlogUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=BlogUserRepository::class)
 * @UniqueEntity(fields="Login", message="Login je již obsazen, prosím zvolte jiný")
 */
class BlogUser implements UserInterface, \Serializable
{ 
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\Column(name="login", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="Listeners require a name")
     */
    private $Login;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Password;

    /**
     * @ORM\Column(type="datetime")
     */
    private $RegistredAt;

    /**
     * @var int
     *
     * @ORM\Column(name="role", type="smallint")
     */
    private $Role;




//---------------------------------------SET/GET-------------------------------------------------------------

    public function  __construct()
    {
        $this->RegistredAt = new \DateTime();    
        $this->Role = 1;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->Login;
    }

    public function setLogin(string $Login): self
    {
        $this->Login = $Login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): self
    {
        $this->Password = $Password;

        return $this;
    }

    public function getRegistredAt(): ?\DateTimeInterface
    {
        return $this->RegistredAt;
    }

    public function setRegistredAt(\DateTimeInterface $RegistredAt): self
    {
        $this->RegistredAt = $RegistredAt;

        return $this;
    }

    public function getUsername()
    {
        return $this->Login;
    }

        /**
     * Set role.
     *
     * @param int $role
     *
     * @return RSP_uzivatel
     */
    public function setRole($role)
    {
        $this->Role = $role;

        return $this;
    }

    /**
     * Get role.
     *
     * @return int
     */
    public function getRole()
    {
        return $this->Role;
    }

    //------------------------------- AUTHENTICATION ---------------------------------------

    public function getRoles()
    {
        switch ($this->getRole())
        {
            case 1:
                return array('ROLE_USER');
                break;
            case 2:
                return array('ROLE_ADMIN');
                break;
            default:
                return array(null);
        }
    }
    public function getSalt()
    {
        // leaving blank - I don't need/have a password!
    }
    public function eraseCredentials()
    {
        // leaving blank - I don't need/have a password!
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->Login,
            $this->Password,
            // see section on salt below
            // $this->salt,
        ]);
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->Login,
            $this->Password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }

    public function __toString() {

        return $this->Login;
    }
}

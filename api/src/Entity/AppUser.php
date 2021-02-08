<?php

namespace App\Entity;

use ApiPlatform\Core\Action\NotFoundAction;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AppUserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AppUserRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'post'
    ],
    itemOperations: [
        'get' => [
            'controller' => NotFoundAction::class,
            'read' => false,
            'output' => false,
        ]
    ]
)]
class AppUser implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Reservation
     *
     * @ORM\OneToMany(targetEntity="Reservation", mappedBy="app_user", cascade={"persist", "remove"})
     */
    public iterable $reservations;
    
    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Assert\Email]
    public string $email;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\Length(
     *     min = 8
     * )
     */
    public string $password;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    
    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername()
    {
        
    }

    public function eraseCredentials()
    {
        
    }
}

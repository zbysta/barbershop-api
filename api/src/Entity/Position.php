<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PositionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PositionRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'get'
    ],
    itemOperations: [
        'get'
    ]
)]
class Position
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $name;

    /**
     * @var Reservation
     *
     * @ORM\OneToMany(targetEntity="Reservation", mappedBy="position", cascade={"persist", "remove"})
     */
    public iterable $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ReservationRepository;
use App\Validator\Constraints\HourMinute;
use App\Validator\Constraints\Time;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Time
 * @ORM\Entity(repositoryClass=ReservationRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'get',
        'post'
    ],
    itemOperations: [
        'get'
    ]
)]
class Reservation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Position[] positions for this reservation.
     *
     * @ORM\ManyToOne(targetEntity="Position", inversedBy="reservations")
     */
    public Position $position;

    /**
     * @var AppUser[] users for this reservation.
     *
     * @ORM\ManyToOne(targetEntity="AppUser", inversedBy="reservations")
     */
    public AppUser $app_user;

    /**
     * @HourMinute
     * @ORM\Column(type="time")
     */
    private $time_start;

    /**
     * @HourMinute
     * @ORM\Column(type="time")
     */
    private $time_end;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimeStart(): ?\DateTimeInterface
    {
        return $this->time_start;
    }

    public function setTimeStart(\DateTimeInterface $time_start): self
    {
        $this->time_start = $time_start;

        return $this;
    }

    public function getTimeEnd(): ?\DateTimeInterface
    {
        return $this->time_end;
    }

    public function setTimeEnd(\DateTimeInterface $time_end): self
    {
        $this->time_end = $time_end;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
    
    public function setAppUser(AppUser $appUser): self
    {
        $this->app_user = $appUser;
        
        return $this;
    }
}

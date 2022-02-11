<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 */
#[ApiResource(
    itemOperations: ['get'],
    normalizationContext: ['groups' => ['bookings','bookings:get']],
    denormalizationContext: ['groups' => ['bookings']],
    collectionOperations: ['get','post']
)]
#[ApiFilter(DateFilter::class,properties: ['startDate','endDate'])]
class Booking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['bookings:get'])]
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['bookings'])]
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['bookings'])]
    private $car;

    /**
     * @ORM\Column(type="date")
     */
    #[Groups(['bookings'])]
    private $startDate;

    /**
     * @ORM\Column(type="date")
     */
    #[Groups(['bookings'])]
    private $endDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?int
    {
        return $this->user;
    }

    public function setUser(int $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCar(): ?int
    {
        return $this->car;
    }

    public function setCar(int $car): self
    {
        $this->car = $car;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\BookingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 */
#[ApiResource(
    normalizationContext: ['groups' => ['bookings','bookings:get']],
    denormalizationContext: ['groups' => ['bookings']],
    collectionOperations: ['get',
        'post' => [
            "security" => "is_granted('ROLE_CLIENT') or is_granted('ROLE_PRO')",
            "security_message" => "Vous ne pouvez pas ajouter de réservation",
        ]
    ],
    itemOperations: [
        'get' => [
            "security" => "is_granted('view_booking',object)",
            "security_message" => "Vous ne pouvez pas afficher cette reservation",
        ]
    ],
)]
#[ApiFilter(DateFilter::class,properties: ['startDate','endDate'])]
#[ApiFilter(SearchFilter::class,properties: ['user'])]
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
     * @Assert\NotBlank
     */
    #[Groups(['bookings'])]
    private $user;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     */
    #[Groups(['bookings'])]
    private $car;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     */
    #[Groups(['bookings'])]
    private $startDate;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     */
    #[Groups(['bookings'])]
    private $endDate;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThan(10,message="Le prix de la location ne peut pas être inférieur à {{ value }} €")
     */
    #[Groups(['bookings'])]
    private $price;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThan(3, message="Le kilométrage du véhicule ne peut pas être inférieur à 3km")
     */
    #[Groups(['bookings'])]
    private $kilometer;

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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getKilometer(): ?int
    {
        return $this->kilometer;
    }

    public function setKilometer(int $kilometer): self
    {
        $this->kilometer = $kilometer;

        return $this;
    }
}

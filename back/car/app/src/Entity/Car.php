<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CarRepository::class)
 */
#[ApiResource]
class Car
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/", message="Le code couleur ne correspond pas")
     */
    private $color;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThan(3, message="Le kilométrage du véhicule ne peut pas être inférieur à 3km")
     */
    private $kilometer;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $numberplate;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 3,
     *      max = 1500,
     *      minMessage = "La puissance du véhicule ne peut pas être inférieur à {{ limit }}	 CH",
     *      maxMessage = "La puissance du véhicule ne peut pas être supérieur à {{ limit }}	 CH"
     * )
     */
    private $power;

    /**
     * @ORM\Column(type="float")
     * @Assert\GreaterThan(10,message="Le prix de la location ne peut pas être inférieur à {{ value }} €")
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="string",length=100)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="car")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     */
    private $date_registration;

    /**
     * @ORM\ManyToOne(targetEntity=Model::class, inversedBy="cars")
     * @ORM\JoinColumn(nullable=false)
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $statusAdminCar;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

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

    public function getNumberplate(): ?string
    {
        return $this->numberplate;
    }

    public function setNumberplate(string $numberplate): self
    {
        $this->numberplate = $numberplate;

        return $this;
    }

    public function getPower(): ?int
    {
        return $this->power;
    }

    public function setPower(int $power): self
    {
        $this->power = $power;

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

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getDateRegistration(): ?\DateTimeInterface
    {
        return $this->date_registration;
    }

    public function setDateRegistration(\DateTimeInterface $date_registration): self
    {
        $this->date_registration = $date_registration;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getStatusAdminCar(): ?string
    {
        return $this->statusAdminCar;
    }

    public function setStatusAdminCar(string $statusAdminCar): self
    {
        $this->statusAdminCar = $statusAdminCar;

        return $this;
    }
}

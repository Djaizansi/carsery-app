<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ModelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ModelRepository::class)
 */
#[ApiResource(
    formats: ['json', 'jsonld'],
    attributes: ["pagination_items_per_page" => 200],
    collectionOperations: [
        'get',
        'post' => [
            "security" => "is_granted('ROLE_ADMIN')",
            "security_message" => "Vous ne pouvez pas ajouter de modèle",
        ],
    ],
    itemOperations: ['get']
)]
class Model
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['brands:get'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['brands:get','cars:get','brands:post'])]
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class, inversedBy="models")
     * @ORM\JoinColumn(nullable=false)
     */
    #[Groups(['cars:get'])]
    private $brand;

    /**
     * @ORM\OneToMany(targetEntity=Car::class, mappedBy="model", orphanRemoval=true)
     */
    private $cars;

    public function __construct()
    {
        $this->cars = new ArrayCollection();
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

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return Collection|Car[]
     */
    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function addCar(Car $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars[] = $car;
            $car->setModel($this);
        }

        return $this;
    }

    public function removeCar(Car $car): self
    {
        if ($this->cars->removeElement($car)) {
            // set the owning side to null (unless already changed)
            if ($car->getModel() === $this) {
                $car->setModel(null);
            }
        }

        return $this;
    }
}

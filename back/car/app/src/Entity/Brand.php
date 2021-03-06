<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BrandRepository::class)
 */
#[ApiResource(
    attributes: ["pagination_items_per_page" => 200],
    denormalizationContext: ['groups' => ['brands:post']],
    normalizationContext: ['groups' => ['brands:get']],
    collectionOperations: [
        'post' => [
            "security" => "is_granted('ROLE_ADMIN')",
            "security_message" => "Vous ne pouvez pas ajouter de marque",
        ],
        'get'
    ],
    itemOperations: ['get']
)]
#[ApiFilter(OrderFilter::class, properties: ['name'])]
class Brand
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
     * @Assert\NotBlank
     */
    #[Groups(['brands:get','cars:get','brands:post'])]
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Model::class, mappedBy="brand", orphanRemoval=true, cascade={"persist", "remove"})
     * @Assert\NotBlank
     */
    #[Groups(['brands:get','brands:post'])]
    private $models;

    public function __construct()
    {
        $this->models = new ArrayCollection();
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

    /**
     * @return Collection|Model[]
     */
    public function getModels(): Collection
    {
        return $this->models;
    }

    public function addModel(Model $model): self
    {
        if (!$this->models->contains($model)) {
            $this->models[] = $model;
            $model->setBrand($this);
        }

        return $this;
    }

    public function removeModel(Model $model): self
    {
        if ($this->models->removeElement($model)) {
            // set the owning side to null (unless already changed)
            if ($model->getBrand() === $this) {
                $model->setBrand(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
#[ApiResource(
    collectionOperations: ['get','post'],
    itemOperations: [
        'get',
        'put' => [
            'security' => "is_granted('edit_address',object)",
            'security_message' => "Modification impossible"
        ]
    ],
    denormalizationContext: ['groups' => 'addresses:post'],
    normalizationContext: ['groups' => 'addresses:get']
)]
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['user:get'])]
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['users:post','user:get','addresses:post','user:put'])]
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['users:post','user:get','addresses:post','user:put'])]
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['users:post','user:get','addresses:post','user:put'])]
    private $street;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['users:post','user:get','addresses:post','user:put'])]
    private $region;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['users:post','user:get','addresses:post','user:put'])]
    private $country;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="address", cascade={"persist", "remove"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setAddress(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getAddress() !== $this) {
            $user->setAddress($this);
        }

        $this->user = $user;

        return $this;
    }
}

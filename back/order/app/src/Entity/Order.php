<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Helpers\RandomNumberSize;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
#[ApiResource(
    normalizationContext: ['groups'=> ['orders:getAndPost','orders:id']],
    denormalizationContext: ['groups' => ['orders:getAndPost']],
    collectionOperations: ['post','get']
)]
#[ApiFilter(SearchFilter::class,properties: ["booking" => "exact"])]
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['orders:id'])]
    private $id;

    /**
     * @ORM\Column(type="string",length=20)
     */
    #[Groups(['orders:getAndPost'])]
    private $num;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['orders:getAndPost'])]
    private $booking;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['orders:getAndPost'])]
    private $amount;

    public function __construct()
    {
        $this->num = "FR-CAR-".RandomNumberSize::getNumberRandom(7);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNum(): ?string
    {
        return $this->num;
    }

    public function setNum(string $num): self
    {
        $this->num = $num;

        return $this;
    }

    public function getBooking(): ?int
    {
        return $this->booking;
    }

    public function setBooking(int $booking): self
    {
        $this->booking = $booking;

        return $this;
    }

    public function getAmount(): ?int
    {
        return ($this->amount/100);
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}

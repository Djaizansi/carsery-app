<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 */
#[ApiResource(
    collectionOperations: ['post','get'],
    normalizationContext: ['groups' => 'payments:post','payments:get'],
    denormalizationContext: ['groups' => 'payments:post'],
    itemOperations: ['get']
)]
#[ApiFilter(SearchFilter::class,properties: ["orderId" => "exact"])]
class Payment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['payments:get'])]
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    #[Groups(['payments:post'])]
    private $orderId;

    /**
     * @ORM\Column(type="string",length=30)
     */
    #[Groups(['payments:post'])]
    private $cbTransactionStripe;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[Groups(['payments:post'])]
    private $cbTransactionMethodStripe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function getCbTransactionStripe(): ?string
    {
        return $this->cbTransactionStripe;
    }

    public function setCbTransactionStripe(string $cbTransactionStripe): self
    {
        $this->cbTransactionStripe = $cbTransactionStripe;

        return $this;
    }

    public function getCbTransactionMethodStripe(): ?string
    {
        return $this->cbTransactionMethodStripe;
    }

    public function setCbTransactionMethodStripe(string $cbTransactionMethodStripe): self
    {
        $this->cbTransactionMethodStripe = $cbTransactionMethodStripe;

        return $this;
    }
}
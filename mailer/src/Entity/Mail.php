<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MailRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\MailerSendController;

/**
 * @ORM\Entity(repositoryClass=MailRepository::class)
 */
#[ApiResource(
    collectionOperations: [
        'mail_send' => [
            'method' => 'POST',
            'path' => '/mail/send',
            'controller' => MailerSendController::class,
            'read' => false,
            'write' => false,
            'openapi_context' => [
                'summary' => 'Envoi de mail',
                'description' => 'Pouvoir envoyer par mail la validation de compte',
            ],
        ],
    ],
    itemOperations: []
)]
class Mail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subject;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $template;

    /**
     * @ORM\Column(type="json")
     */
    private $data = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(string $template): self
    {
        $this->template = $template;

        return $this;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }
}

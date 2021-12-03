<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\ActivationAccount;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity("email",message="L'email existe déjà. Veuillez réessayer")
 */

#[ApiResource(
    collectionOperations: [
        'get',
        'post',
        'activation_account' => [
            'method' => 'POST',
            'path' => '/activation/account',
            'controller' => ActivationAccount::class,
            'read' => false,
            'write' => false,
            'denormalization_context' => ['groups' => ['activation_account']],
            'openapi_context' => [
                'summary' => 'Activation du compte',
                'responses' => [
                    '200' => [
                        'description' => 'Activation réussi',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'string',
                                    'example' => 'Votre compte a été activé'
                                ]
                            ]
                        ],
                    ],
                    '201' => null
                ]
            ]
        ]
    ],
    denormalizationContext: ['groups' => ['users:post']],
    itemOperations: [
        'get',
        'patch'
    ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    const ROLES = [['ROLE_CLIENT'],['ROLE_PRO']];
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(message="Votre email est invalide")
     */
    #[Groups(['users:post'])]
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Assert\Choice(choices=User::ROLES, message="Choisissez un role valide")
     */
    #[Groups(['users:post'])]
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Regex("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", message=" Votre mot de passe doit contenir : Min 8 caractères | Min 1 chifffre | Min caractère majuscule et minuscule")
     */
    #[Groups(['users:post'])]
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 3,
     *      max = 30,
     *      minMessage = "Votre prénom doit contenir minimum {{ limit }} caractères",
     *      maxMessage = "Votre prénom doit contenir minimum {{ limit }} caractères"
     * )
     */
    #[Groups(['users:post'])]
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Votre nom doit contenir minimum {{ limit }} caractères",
     *      maxMessage = "Votre nom doit contenir maximum {{ limit }} caractères"
     * )
     */
    #[Groups(['users:post'])]
    private $lastname;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(['activation_account'])]
    private $token;

    /**
     * @ORM\OneToOne(targetEntity=Client::class, inversedBy="user", cascade={"persist", "remove"})
     */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity=Professional::class, inversedBy="user", cascade={"persist", "remove"})
     */
    private $professional;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, inversedBy="user", cascade={"persist", "remove"})
     */
    private $address;

    public function __construct(){
        $this->createdAt = new \DateTime();
    }

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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getProfessional(): ?Professional
    {
        return $this->professional;
    }

    public function setProfessional(?Professional $professional): self
    {
        $this->professional = $professional;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }
}

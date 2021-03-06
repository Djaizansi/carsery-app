<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\ActivationAccount;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
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
        'get' => [
            "normalization_context" => ["groups" => ['user:get']]
        ],
        'put' => [
            "security" => "is_granted('edit',object)",
            "security_message" => "Modification impossible",
            "denormalization_context" => ['groups' => ['user:put']]
        ]
    ]
)]
#[ApiFilter(SearchFilter::class,properties: ["type" => "exact"])]
class User implements UserInterface, PasswordAuthenticatedUserInterface, JWTUserInterface
{
    const ROLES = [['ROLE_CLIENT'],['ROLE_PRO'],['ROLE_ADMIN']];
    const GENDER = ['M', 'F'];
    const TYPES = ['customer','pro','admin'];
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
    #[Groups(['users:post','user:get'])]
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Assert\Choice(choices=User::ROLES, message="Choisissez un role valide")
     */
    #[Groups(['users:post','user:get'])]
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    #[Groups(['users:post','user:put'])]
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
    #[Groups(['users:post','user:get','user:put'])]
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
    #[Groups(['users:post','user:get','user:put'])]
    private $lastname;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     * @Assert\Choice(choices=User::GENDER, message="Choisissez un genre valide")
     */
    #[Groups(['users:post','user:get','user:put'])]
    private $gender;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min = 2,
     *     minMessage="Le nom de l'entreprise ne peut pas être inférieur à 2 caractères"
     * )
     */
    #[Groups(['users:post','user:get','user:put'])]
    private $company;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *     min = 14,
     *     max = 14,
     *     exactMessage="Le numéro de siret doit comporter exactement 14 chiffres"
     * )
     */
    #[Groups(['users:post','user:get','user:put'])]
    private $siret;


    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(['activation_account'])]
    private $tokenAccount;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, inversedBy="user", cascade={"persist", "remove"})
     */
    #[Groups(['users:post','address:post','user:get','user:put'])]
    private $address;

    /**
     * @Assert\Regex("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", message=" Votre mot de passe doit contenir : Min 8 caractères | Min 1 chifffre | Min caractère majuscule et minuscule")
     */
    #[Groups(['users:post','user:put'])]
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[Groups(['user:put'])]
    private $oldPassword;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\Choice(choices=User::TYPES, message="Choisissez un type valide")
     */
    #[Groups(['users:post'])]
    private $type;

    public function __construct(){
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
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
        return (int) $this->id;
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

    public function getTokenAccount(): ?string
    {
        return $this->tokenAccount;
    }

    public function setTokenAccount(?string $tokenAccount): self
    {
        $this->tokenAccount = $tokenAccount;

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

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender($gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(?string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(?string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public static function createFromPayload($id, array $payload)
    {
        $user = new User();
        return $user;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(?string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}

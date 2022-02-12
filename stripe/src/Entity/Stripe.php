<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\StripeController;
use App\Controller\StripeGetInfoController;

#[ApiResource(
    collectionOperations: [
        'stripe_init' => [
            'method' => 'POST',
            'path' => '/stripe/intent',
            'controller' => StripeController::class,
            'read' => false,
            'write' => false,
            'pagination_enabled' => false,
            'openapi_context' => [
                'summary' => 'Permet de récupèrer la clé secrete pour lancer les paiements',
                'requestBody' => [
                    'required' => true,
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'price' => ['type' => 'integer']
                                ]
                            ]
                        ]
                    ]
                ],
                'responses' => [
                    '200' => [
                        'description' => 'OK',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'string',
                                    'example' => 'pi_3JteEiAO5vDzLaAV0xeDJHEv_secret_XBVeuQGNdzZYDtMfjdizzIXGmGwaaaasz'
                                ]
                            ]
                        ],
                    ],
                    '201' => null
                ]
            ]
        ],
        'stripe_get_payment' => [
            'method' => 'POST',
            'path' => '/stripe/info',
            'controller' => StripeGetInfoController::class,
            'read' => false,
            'write' => false,
            'pagination_enabled' => false,
            'openapi_context' => [
                'summary' => "Permet de récupèrer les infos de paiement grâce à l'id de paiement",
                'requestBody' => [
                    'required' => true,
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'idChargeStripe' => ['type' => 'string']
                                ]
                            ]
                        ]
                    ]
                ],
                'responses' => [
                    '200' => [
                        'description' => 'OK',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'string',
                                    'example' => '{PaymentIntent}'
                                ]
                            ]
                        ],
                    ],
                    '201' => null
                ]
            ]
        ],
    ],
    itemOperations: [],
)]
class Stripe {

    #[ApiProperty(
        description: 'Id charge stripe',
        identifier: true
    )]
    private $idChargeStripe;

    #[ApiProperty(
        description: 'Token stripe'
    )]
    private $stripeToken;

    #[ApiProperty(
        description: 'Carte utilisé'
    )]
    private $brandStripe;

    #[ApiProperty(
        description: 'Les 4 derniers chiffres de la carte'
    )]
    private $last4Stripe;

    #[ApiProperty(
        description: 'Le status du paiement'
    )]
    private $statusStripe;

    public function getStripeToken(): ?string
    {
        return $this->stripeToken;
    }

    /**
     * @param null|string $stripeToken
     */
    public function setStripeToken(?string $stripeToken): void
    {
        $this->stripeToken = $stripeToken;
    }

    /**
     * @return null|string
     */
    public function getBrandStripe(): ?string
    {
        return $this->brandStripe;
    }

    /**
     * @param null|string $brandStripe
     */
    public function setBrandStripe(?string $brandStripe): void
    {
        $this->brandStripe = $brandStripe;
    }

    /**
     * @return null|string
     */
    public function getLast4Stripe(): ?string
    {
        return $this->last4Stripe;
    }

    /**
     * @param null|string $last4Stripe
     */
    public function setLast4Stripe(?string $last4Stripe): void
    {
        $this->last4Stripe = $last4Stripe;
    }

    /**
     * @return null|string
     */
    public function getIdChargeStripe(): ?string
    {
        return $this->idChargeStripe;
    }

    /**
     * @param null|string $idChargeStripe
     */
    public function setIdChargeStripe(?string $idChargeStripe): void
    {
        $this->idChargeStripe = $idChargeStripe;
    }

    /**
     * @return null|string
     */
    public function getStatusStripe(): ?string
    {
        return $this->statusStripe;
    }

    /**
     * @param null|string $statusStripe
     */
    public function setStatusStripe(?string $statusStripe): void
    {
        $this->statusStripe = $statusStripe;
    }
}

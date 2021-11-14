<?php

namespace App\Services;

use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;

class StripeService
{
    public const CURRENCY = 'eur';

    private $privateKey;

    public function __construct()
    {
        $this->privateKey = $_ENV['STRIPE_SECRET_KEY_TEST'];
    }

    /**
     * @param $price
     * @return PaymentIntent
     * @throws ApiErrorException
     */
    public function paymentIntent($price): PaymentIntent
    {
        \Stripe\Stripe::setApiKey($this->privateKey);

        return PaymentIntent::create([
            'amount' => $price * 100,
            'currency' => self::CURRENCY,
            'description' => 'Location de voiture',
            'payment_method_types' => ['card']
        ]);
    }
}

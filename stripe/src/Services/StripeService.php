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
            'payment_method_types' => ['card']
        ]);
    }

    /**
     * @throws ApiErrorException
     */
    public function paiement(
        $amount,
        $currency,
        $description,
        array $stripeParameter
    ): ?PaymentIntent
    {
        \Stripe\Stripe::setApiKey($this->privateKey);
        $payment_intent = null;

        if(isset($stripeParameter['stripeIntentId'])) {
            $payment_intent = PaymentIntent::retrieve($stripeParameter['stripeIntentId']);
        }

        if($stripeParameter['stripeIntentStatus'] === 'succeeded') {
            //TODO
        } else {
            $payment_intent->cancel();
        }

        return $payment_intent;
    }

    /**
     * @param array $stripeParameter
     * @param $price
     * @param $name
     * @return PaymentIntent|null
     */
    public function stripe(array $stripeParameter, $price, $name): ?PaymentIntent
    {
        return $this->paiement(
            $price * 100,
            self::CURRENCY,
            $name,
            $stripeParameter
        );
    }
}

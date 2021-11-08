<?php

namespace App\Controller;

use App\Services\StripeService;
use Stripe\Exception\ApiErrorException;
use Symfony\Component\HttpFoundation\Request;

class StripeController
{
    public function __construct(private StripeService $stripeService){}

    public function __invoke(Request $request): ?string
    {
        $price = array_key_exists('price', $request->toArray()) ? $request->toArray()["price"] : '';
        return !empty($price) ? $this->stripeService->paymentIntent($price)["client_secret"] : null;
    }
}
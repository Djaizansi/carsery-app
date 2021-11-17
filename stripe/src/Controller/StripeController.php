<?php

namespace App\Controller;

use App\Services\StripeService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class StripeController
{
    public function __construct(private StripeService $stripeService)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $price = array_key_exists('price', $request->toArray()) ? $request->toArray()["price"] : '';
        return !empty($price) ? new JsonResponse($this->stripeService->paymentIntent($price)["client_secret"], 200) : new JsonResponse(null, 500);
    }
}

<?php


namespace App\Controller;


use Stripe\Exception\ApiErrorException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Services\StripeService;

class StripeGetInfoController
{
    public function __construct(private StripeService $stripeService){}

    /**
     * @throws ApiErrorException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $idPaymentMethod = $request->attributes->get('data')->getIdChargeStripe();
        return new JsonResponse($this->stripeService->paymentMethod($idPaymentMethod),200);
    }
}

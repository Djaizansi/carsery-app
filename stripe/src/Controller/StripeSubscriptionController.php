<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Services\StripeService;

class StripeSubscriptionController
{
    public function __construct(private StripeService $stripeService){}

    public function __invoke(Request $request): JsonResponse
    {
//        $resource = null;
//        $data = $this->stripeService->stripe($stripeParameter, $product);
//
//        if($data) {
//            $resource = [
//                'stripeBrand' => $data['charges']['data'][0]['payment_method_details']['card']['brand'],
//                'stripeLast4' => $data['charges']['data'][0]['payment_method_details']['card']['last4'],
//                'stripeId' => $data['charges']['data'][0]['id'],
//                'stripeStatus' => $data['charges']['data'][0]['status'],
//                'stripeToken' => $data['client_secret']
//            ];
//        }
//
//        return $resource;
    }
}

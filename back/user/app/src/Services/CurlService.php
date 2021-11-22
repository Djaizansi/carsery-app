<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CurlService{
    public function __construct(private HttpClientInterface $client){}

    public function curlData($method, $url, $body): JsonResponse
    {
        $response = $this->client->request($method, $url, [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => $body
        ]);
        return new JsonResponse('envoi de mail réussi bg',200);
    }
}

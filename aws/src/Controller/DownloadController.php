<?php

namespace App\Controller;

use App\Services\AmazonService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DownloadController {

    public function __invoke(Request $request, AmazonService $client): JsonResponse
    {
        $param = $request->attributes->get('data');
        $name = $param->getName();
        $path = $param->getFilePath();
        if(is_null($path)){
            return new JsonResponse("path not found",400);
        }
        $data = !is_null($name) ? $client->getObjectFunc($path,$name) : $client->listAllObjectFunc($path);
        return new JsonResponse($data,200);
    }
}

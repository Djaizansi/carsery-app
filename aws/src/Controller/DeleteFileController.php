<?php

namespace App\Controller;

use App\Services\AmazonService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DeleteFileController {

    public function __invoke(Request $request, AmazonService $client): JsonResponse
    {
        $param = $request->attributes->get('data');
        $path = $param->getFilePath();
        if(is_null($path)){
            return new JsonResponse("path not found",400);
        }
        $data = $client->deleteObjectFun($path);
        if($data){
            return new JsonResponse('Suppression réussi',204);
        }
        return new JsonResponse("Une erreur est survenue $data",404);
    }
}

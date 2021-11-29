<?php

namespace App\Controller;

use App\Services\AmazonService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DownloadController {

    public function __invoke(Request $request, AmazonService $client)
    {
        $route = $request->get('_route');
        if($route === 'api_documents_getOneElement_collection'){
            dd('coucou');
        }else if($route === 'api_documents_getList_collection'){
            $param = $request->attributes->get('data');
            $data = $client->listAllObjectFunc($param->getFilePath());
            return new JsonResponse($data,200);
        }
    }
}

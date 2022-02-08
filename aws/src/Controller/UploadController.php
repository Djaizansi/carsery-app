<?php

namespace App\Controller;

use App\Services\AmazonService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Mime\MimeTypes;

class UploadController {

    public function __invoke(Request $request, AmazonService $client)
    {
        $uploadedFiles = $request->request->get('file');
        $path = $request->request->get('path');
        $returnSucces = new JsonResponse("Une erreur est survenue",500);
        foreach ($uploadedFiles as $file) {
            if (!$file) {
                throw new BadRequestHttpException('"file" is required');
            }
            $fp = fopen($file,'r');
            $meta = mime_content_type($fp);
            $extension = explode('/',$meta)[1];
            $uniqName   = uniqid().'.'.$extension;
            $pathFinal = $path.'/'.$uniqName;
            $data = $client->putObjectFunc($pathFinal,$file);
            $returnSucces = $data ? new JsonResponse('Upload réussi',201) : new JsonResponse(`Une erreur est survenue :${data}`,404);
        }
        return $returnSucces;
    }
}

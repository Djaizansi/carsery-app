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
        $uploadedFile = $request->files->get('file');
        $path = $request->request->get('path');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $mime = new MimeTypes();
        $typeFile = $mime->getExtensions($uploadedFile->getMimeType())[0];
        $uniqName   = uniqid().'.'.$typeFile;
        $pathFinal = $path.$uniqName;
        $data = $client->putObjectFunc($pathFinal,$uploadedFile);
        return ($data ? new JsonResponse('Upload réussi',201) : new JsonResponse(`Une erreur est survenue :${data}`,201));
    }
}

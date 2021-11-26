<?php

namespace App\Controller;

use App\Entity\Document;
use App\Services\AmazonService;
use Aws\S3\S3Client;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Mime\MimeTypes;

class UploadController {

    public function __invoke(Request $request, AmazonService $client)
    {
        $uploadedFile = $request->files->get('file');
        $nameFileRequest = $request->request->get('name');
        $nameFile = !$nameFileRequest ? $uploadedFile->getClientOriginalName() : $nameFileRequest;
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }

        $mime = new MimeTypes();
        $typeFile = $nameFileRequest ? $mime->getExtensions($uploadedFile->getMimeType())[0] : '';
        $data = $client->putObjectFunc('voitures',$nameFile,$uploadedFile,$typeFile);
        return ($data ? new JsonResponse('Upload réussi',201) : new JsonResponse(`Une erreur est survenue :${data}`,201));
    }
}

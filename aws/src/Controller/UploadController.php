<?php

namespace App\Controller;

use App\Entity\Document;
use Aws\S3\S3Client;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UploadController {

    public function __invoke(Request $request): Document
    {
        $uploadedFile = $request->files->get('file');
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"file" is required');
        }
//        $s3Client = new S3Client([
//            'profile' => 'default',
//            'region' => 'us-west-2',
//            'version' => '2006-03-01'
//        ]);
//        $result = $s3Client->putObject([
//            'Bucket' => '%assets_bucket%',
//            'Key' => 'Data',
//            'SourceFile' => $uploadedFile,
//        ]);
        //dd($s3Client);
        $document = new Document();
        $document->setFile($uploadedFile);
        return $document;
    }
}

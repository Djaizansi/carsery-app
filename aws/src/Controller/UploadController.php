<?php

namespace App\Controller;

use App\Entity\Document;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UploadController {

    public function __invoke(Request $request){
        $document = new Document();
        $file = $request->files->get('file');
        $document->setFile($file);
        return new JsonResponse('Image enregistrée',201);
    }
}
<?php

namespace App\Services;

use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;

class AmazonService {
    private S3Client $s3Client;

    public function __construct(){
        $this->s3Client = new S3Client([
            'region' => $_ENV['AWS_REGION'],
            'version' => 'latest',
            'credentials' => [
                'key' => $_ENV['AWS_KEY'],
                'secret' => $_ENV['AWS_SECRET']
            ]
        ]);
    }

    public function putObjectFunc($path,$data){
        try {
            $this->s3Client->putObject([
                'Bucket' => $_ENV['AWS_BUCKET'],
                'Key' => $path,
                'Body'   => fopen($data, 'r')
            ]);
            return 1;
        }catch(S3Exception $e){
            return $e->getMessage();
        }
    }

    public function deleteObjectFun($path){
        try {
            $this->s3Client->deleteObject([
                'Bucket' => $_ENV['AWS_BUCKET'],
                'Key' => $path
            ]);
            return 1;
        }catch(S3Exception $e){
            return $e->getMessage();
        }
    }

    public function getObjectFunc($path,$nameFile){
        try {
            $data = $this->s3Client->getObject([
                'Bucket' => $_ENV['AWS_BUCKET'],
                'Key' => $path.$nameFile
            ]);
            return $data["@metadata"]["effectiveUri"];
        }catch(S3Exception $e){
            return $e->getMessage();
        }
    }

    public function listAllObjectFunc($path){
        try {
            $array = [];
            $data = $this->s3Client->listObjectsV2([
                'Bucket' => $_ENV['AWS_BUCKET'],
                'Key' => $path,
                'Prefix' => $path
            ]);

            foreach($data->get('Contents') as $content){
                $url = $_ENV['AWS_URI'] . '/' . $content['Key'];
                array_push($array,$url);
            }
            return $array;
        }catch(S3Exception $e){
            return $e->getMessage();
        }
    }
}

<?php

namespace App\Services;

use Aws\Exception\AwsException;
use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;

class AmazonService {
    private $s3Client;

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

    public function putObjectFunc($path, $name, $data, $typeFile=null){
        try {
            $this->s3Client->putObject([
                'Bucket' => $_ENV['AWS_BUCKET'],
                'Key' => $path.'/'.$name.($typeFile ? '.'.$typeFile : ''),
                'Body'   => fopen($data, 'r')
            ]);
            return 1;
        }catch(S3Exception $e){
            return $e->getMessage();
        }
    }
}
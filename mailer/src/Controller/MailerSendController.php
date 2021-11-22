<?php

namespace App\Controller;

use App\Services\MailService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MailerSendController
{
    public function __construct(private MailService $mailer){}
    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->attributes->all()['data'];
        if(!is_null($data->getEmail()) || !is_null($data->getSubject()) || !is_null($data->getTemplate())){
            $this->mailer->sendMail($data->getEmail(),$data->getSubject(),$data->getTemplate(),$data->getData());
            return new JsonResponse('',200);
        }
        return new JsonResponse('',500);
    }
}

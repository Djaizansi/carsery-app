<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ActivationAccount {
    public function __construct(private EntityManagerInterface $em){}

    public function __invoke(Request $request){
        $token = $request->attributes->get('data')->getToken();
        $user = $this->em->getRepository(User::class)->findBy(['token' => $token]);
        if($user){
            $user[0]->setToken(null);
            $this->em->flush();
            return new JsonResponse('',200);
        }
        return new JsonResponse('',400);
    }
}

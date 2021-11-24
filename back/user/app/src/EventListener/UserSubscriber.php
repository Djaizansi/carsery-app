<?php

namespace App\EventListener;

use App\Entity\User;
use App\Services\CurlService;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class UserSubscriber implements EventSubscriberInterface
{
    public function __construct(private UserPasswordHasherInterface $encoder, private CurlService $curl)
    {}

    // this method can only return the event names; you cannot define a
    // custom method name to execute when each event triggers
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
            Events::postPersist
        ];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $this->sendMail($args);
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $this->addTokenAccount($args);
        $this->encodePassword($args);
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $this->encodePassword($args);
    }

    private function checkInstanceEntity($args){
        $entity = $args->getObject();

        if (!$entity instanceof User) {
            return 0;
        }else{
            return $entity;
        }
    }

    private function addTokenAccount(LifecycleEventArgs $args): void
    {
        $entity = $this->checkInstanceEntity($args);
        !is_bool($entity) && $entity->setToken(md5(uniqid()));
    }

    private function encodePassword(LifecycleEventArgs $args): void
    {
        $entity = $this->checkInstanceEntity($args);
        !is_bool($entity) && $entity->setPassword($this->encoder->hashPassword($entity, $entity->getPassword()));
    }

    private function sendMail(LifecycleEventArgs $args){
        $entity = $this->checkInstanceEntity($args);
        $data = [
            "email" => $entity->getEmail(),
            "subject" => 'Valider votre compte',
            "template" => 'validation_account',
            "data" => ['token' => $entity->getToken()]
        ];

        //$this->curl->curlData('POST',"http://mailer-nginx/mail/send", json_encode($data));
    }
}

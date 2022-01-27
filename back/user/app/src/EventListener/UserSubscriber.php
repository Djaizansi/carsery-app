<?php

namespace App\EventListener;

use App\Entity\User;
use App\Services\CurlService;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class UserSubscriber implements EventSubscriberInterface
{
    public function __construct(private UserPasswordHasherInterface $encoder, private CurlService $curl)
    {
    }

    // this method can only return the event names; you cannot define a
    // custom method name to execute when each event triggers
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
            Events::postPersist,
        ];
    }

    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $this->checkInstanceEntity($args);
        $entity && $this->sendMail($entity);
    }

    public function prePersist(LifecycleEventArgs $args): void
    {
        $entity = $this->checkInstanceEntity($args);
        if ($entity) {
            $this->addTokenAccount($entity);
            $this->encodePassword($entity);
        }
    }

    public function preUpdate(LifecycleEventArgs $args): void
    {
        $entity = $this->checkInstanceEntity($args);
        if ($entity) {
            if ($entity->getOldPassword() && !$this->checkPasswordSame($entity)) {
                throw new CustomUserMessageAuthenticationException("unauthorized", [], 401);
            }
            $entity->setOldPassword(null);
            $this->encodePassword($entity);
        }
    }

    private function checkInstanceEntity($args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof User) {
            return 0;
        } else {
            return $entity;
        }
    }

    private function addTokenAccount($entity): void
    {
        $entity->setTokenAccount(md5(uniqid()));
    }

    private function encodePassword($entity): void
    {
        //dd('coucou');
        !is_null($entity->getPlainPassword()) && $entity->setPassword($this->encoder->hashPassword($entity, $entity->getPlainPassword()));
    }

    private function checkPasswordSame($entity): bool
    {
        return $this->encoder->isPasswordValid($entity, $entity->getOldPassword());
    }

    private function sendMail($entity)
    {
        $data = [
            "email" => $entity->getEmail(),
            "subject" => 'Valider votre compte',
            "template" => 'validation_account',
            "data" => ['token' => $entity->getTokenAccount()]
        ];

        $this->curl->curlData('POST', "http://mailer-nginx/mail/send", json_encode($data));
    }
}

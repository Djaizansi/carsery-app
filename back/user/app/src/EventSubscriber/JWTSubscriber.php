<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class JWTSubscriber implements EventSubscriberInterface
{
    public function onLexikJwtAuthenticationOnJwtCreated(JWTCreatedEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();
        if ($user instanceof User) {
            $data['id'] = $user->getId();
            $data['username'] = $event->getUser()->getUsername();
            if (in_array('ROLE_CLIENT', $data['roles'])) {
                $data['firstname'] = $user->getFirstname();
                $data['lastname'] = $user->getLastname();
                $data['gender'] = $user->getGender();
            }else {
                $data['company'] = $user->getCompany();
                $data['siret'] = $user->getSiret();
            }
        }
        $event->setData($data);
    }

    public static function getSubscribedEvents()
    {
        return [
            'lexik_jwt_authentication.on_jwt_created' => 'onLexikJwtAuthenticationOnJwtCreated',
        ];
    }
}

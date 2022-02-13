<?php

namespace App\Security\Voter;

use App\Entity\Car;
use App\Helpers\DecryptToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CarVoter extends Voter
{
    // these strings are just invented: you can use anything
    const VIEW = 'view_car';
    const EDIT = 'edit_car';

    public function __construct(private DecryptToken $decryptToken){}
    protected function supports(string $attribute, $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        // only vote on `Car` objects
        if (!$subject instanceof Car) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $this->decryptToken->decrypt($token);

        // you know $subject is a User object, thanks to `supports()`
        /** @var Car $car */
        $carObject = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($carObject, $user);
            case self::EDIT:
                return $this->canEdit($carObject, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Car $carObject, $user): bool
    {
        // if they can edit, they can view
        if ($this->canEdit($carObject, $user)) {
            return true;
        }
        return false;
    }

    private function canEdit(Car $carObject, $user): bool
    {
        // this assumes that the User object has a `getOwner()` method
        return $user->getId() === $carObject->getUser();
    }
}
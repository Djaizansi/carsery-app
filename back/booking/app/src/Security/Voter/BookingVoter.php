<?php

namespace App\Security\Voter;

use App\Entity\Booking;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class BookingVoter extends Voter
{
    // these strings are just invented: you can use anything
    const VIEW = 'view_booking';
    const EDIT = 'edit_booking';

    public function __construct(private Security $security){}
    protected function supports(string $attribute, $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        // only vote on `Booking` objects
        if (!$subject instanceof Booking) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = (int)$this->security->getToken()->getUserIdentifier();
        // you know $subject is a User object, thanks to `supports()`
        /** @var Booking $booking */
        $bookingObject = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($bookingObject, $user);
            case self::EDIT:
                return $this->canEdit($bookingObject, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(Booking $bookingObject, $user): bool
    {
        // if they can edit, they can view
        if ($this->canEdit($bookingObject, $user)) {
            return true;
        }
        return false;
    }

    private function canEdit(Booking $bookingObject, $user): bool
    {
        // this assumes that the User object has a `getOwner()` method
        return $user === $bookingObject->getUser();
    }
}
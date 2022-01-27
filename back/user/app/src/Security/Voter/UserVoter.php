<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Helpers\DecryptToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter
{
    // these strings are just invented: you can use anything
    const VIEW = 'view';
    const EDIT = 'edit';

    public function __construct(private DecryptToken $decryptToken){}
    protected function supports(string $attribute, $subject): bool
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::VIEW, self::EDIT])) {
            return false;
        }

        // only vote on `Post` objects
        if (!$subject instanceof User) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $this->decryptToken->decrypt($token);
        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // you know $subject is a User object, thanks to `supports()`
        /** @var User $user */
        $userObject = $subject;

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($userObject, $user);
            case self::EDIT:
                return $this->canEdit($userObject, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canView(User $userObject, User $user): bool
    {
        // if they can edit, they can view
        if ($this->canEdit($userObject, $user)) {
            return true;
        }
        return false;
    }

    private function canEdit(User $userObject, User $user): bool
    {
        // this assumes that the User object has a `getOwner()` method
        return $user->getId() === $userObject->getId();
    }
}
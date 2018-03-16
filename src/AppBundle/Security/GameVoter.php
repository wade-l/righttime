<?php

namespace AppBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use AppBundle\Entity\Game;
use AppBundle\Entity\User;
use AppBundle\Entity\Member;

class GameVoter extends Voter
{
    // If someone can do game organizer functions
    const ORGANIZE = 'organize';

    protected function supports($attribute, $subject)
    {
        // Check that we support the attribute
        if (!in_array($attribute, array(self::ORGANIZE))) {
            return false;
        }

        // We only vote on Games
        if (!$subject instanceof Game) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user-> $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        $game = $subject;

        switch ($attribute) {
            case self::ORGANIZE:
                return $this->canOrganize($game, $user);
        }
    }

    private function canOrganize(Game $game, User $user) {
        $user_memberships = $user->getMembers();

        foreach ($user_memberships->getIterator() as $iterator => $member) {
            if ( ( $member->getGame() == $game ) && ($member->getPosition () == $member->POSITION_ORGANIZER) ) {
                return true;
            }
        }

        return false;
    }

}
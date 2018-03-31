<?php

namespace AppBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use AppBundle\Entity\Game;
use AppBundle\Entity\Character;
use AppBundle\Entity\User;
use AppBundle\Entity\Member;

/**
 * Makes access decisions for Characters
 */
class CharacterVoter extends Voter
{
    // If someone owns the character
    const OWN = 'IS_OWNER';
    // If someone has organiational authority over the character
    const ORGANIZE = 'CAN_ORGANIZE';
    //If someone can edit the character
    const EDIT = 'CAN_EDIT';

    protected function supports($attribute, $subject)
    {
        // Check that we support the attribute
        if (!in_array($attribute, array(self::OWN, self::ORGANIZE, self::EDIT))) {
            return false;
        }

        // We only vote on Games
        if (! $subject instanceof Character) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        switch ($attribute) {
            case self::ORGANIZE:
                return $this->canOrganize($subject, $user);
            case self::OWN:
                return $this->canPlay($subject, $user);
            case self::EDIT:
                return $this->canEdit($subject, $user);
        }
    }

    private function canEdit(Character $character, User $user) {
        return ( $this->canOrganize($character, $user) || $this->canOwn($character, $user) );
    }

    private function canOrganize(Character $character, User $user) {
        $user_memberships = $user->getMembers();

        $game = $character->getGame();

        foreach ( $user_memberships->getIterator() as $iterator => $member ) {
            if ( ( $member->getGame() == $game ) && ($member->getPosition () == 'organizer') ) {
                return true;
            }
        }

        return false;
    }

    private function canOwn(Character $character, User $user) {
        if  ( $character->getPlayer() == $user ) {
            return true;
        }

        return false;
    }

}
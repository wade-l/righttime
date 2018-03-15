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
        if (!in_array($attribute, array(self::ORGANIZE)) {
            return false;
        }
    }

}
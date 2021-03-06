<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;

/**
 * DowntimePeriodRepository
 *
 */
class DowntimePeriodRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * Gets all downtime periods that a particular User has characters for (a player)
     */     
    public function findAllByPlayer(User $player) {
        $player_id = $player->getId();
        return $this->getEntityManager()
            ->createQueryBuilder('d')
            ->select('d')
            ->from('AppBundle:DowntimePeriod','d')
            ->innerJoin('d.game', 'g')
            ->innerJoin('g.characters', 'c')
            ->where('c.player = :player')
            ->setParameter('player', $player)
            ->orderBy('d.close', 'DESC')
            ->getQuery()
            ->getResult();
    }
}

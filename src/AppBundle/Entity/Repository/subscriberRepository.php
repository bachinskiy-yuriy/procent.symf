<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Subscriber;

/**
 * subscriberRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class subscriberRepository extends \Doctrine\ORM\EntityRepository
{

    public function addSubscriber($subscriber)
    {
        $em = $this->getEntityManager();
        $em->persist($subscriber);
        $em->flush();
    }
}

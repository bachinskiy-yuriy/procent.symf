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

    public function addSubscriber($user,$mail,$tel)
    {
        $subsc = new Subscriber();
        $subsc->setUser($user);
        $subsc->setMail($mail);
        $subsc->setTel($tel);
        $subsc->setSubscribeDate(new \DateTime());
        $em = $this->getEntityManager();
        $em->persist($subsc);
        $em->flush();
    }
}

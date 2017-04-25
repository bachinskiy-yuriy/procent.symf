<?php

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * creditonlineRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class propositionRepository extends \Doctrine\ORM\EntityRepository
{

    public function getFirstGroup($money,$term)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT P FROM AppBundle:proposition P
        WHERE P.summin<=:money AND P.firstSummax>=:money AND P.daymin<=:term AND P.firstDaymax>=:term 
        ORDER BY P.recomended DESC')
        ->setParameter('money', $money)
        ->setParameter('term',$term);
        $shops = $query->getResult();
        return $shops;
    }

    public function getNextGroup($money,$term)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT P FROM AppBundle:proposition P
        WHERE P.firstSummax<:money AND P.nextSummax>=:money AND P.daymin<=:term AND P.nextDaymax>=:term 
        ORDER BY P.recomended DESC')
        ->setParameter('money', $money)
        ->setParameter('term',$term);
        $shops = $query->getResult();
        return $shops;
    }

    public function getLastGroup($money,$term)
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT P FROM AppBundle:proposition P
        WHERE P.summin>:money OR P.nextSummax<:money OR P.daymin>:term OR P.nextDaymax<:term 
        ORDER BY P.recomended DESC')
        ->setParameter('money', $money)
        ->setParameter('term',$term);
        $shops = $query->getResult();
        return $shops;
    }

    public function getShops()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT P.company, P.id, P.img, P.slug FROM AppBundle:proposition P');
        $shops = $query->getResult();
        return $shops;
    }
    
    // public function addComments($user,$mail,$msg,$rank,$service)
    // {
        // $em = $this->getEntityManager();
        // $proposition = $em->createQuery('SELECT P FROM AppBundle:proposition P WHERE P.id=:id')->setParameter('id', $id);
        // $comment = new Comments();
        // $proposition->setComment($comment);
    // }

    // public function addInfo($company,$article)
    // {
        // $em = $this->getEntityManager();
        // $proposition = $em->createQuery('SELECT P FROM AppBundle:proposition P WHERE P.id=:id')->setParameter('id', $company);
        // $info = new About();
        // $info->setArticle($article);
        // $proposition->setAbout($info);
    // }
    
    public function addProposition($proposition)
    {
        $em = $this->getEntityManager();
        $em->persist($proposition);
    }

    public function Commit()
    {
        $em = $this->getEntityManager();
        $em->flush();
    }
    
}

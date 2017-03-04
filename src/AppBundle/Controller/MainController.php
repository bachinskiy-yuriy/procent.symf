<?php

namespace AppBundle\Controller;

use Symfony\Component\DependencyInjection\Reference;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Comments;

class MainController extends Controller
{    
    /**
     * @Route("/phpinfo", name="info")
     */    
    public function infoAction()
    {
        return new Response(phpinfo());
    }    

    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
        $article = $this->getDoctrine()->getRepository('AppBundle:Articles')->findOneById('/');
        return $this->render('index.html.twig',array('title'=>$article->getTitle(),'article'=>$article));
    }
    
    public function mySort($f1,$f2)
   {
      if(($f1->getRecomended() > 0) || ($f2->getRecomended() > 0)){
          if(($f1->getRecomended() > $f2->getRecomended())) {return -1;} else {return 1;}
      }
      // if(($f1->getRecomended() > 0)) return -1;
      // if(($f2->getRecomended() > 0)) return 1;
      if($f1->commision < $f2->commision) return -1;
      elseif($f1->commision > $f2->commision) return 1;
      else return 0;
   }

    /**
     * @Route("/calc/{money}/{term}", name="calc")
     */    
    public function calcAction($money=2000, $term=30)
    {
        $group1 = $this->getDoctrine()->getRepository('AppBundle:Proposition')->getFirstGroup($money,$term);
        foreach($group1 as $shop){
            $correctCredit365 = 0; 
            $correctCreditUp = 0;
            if($shop->getId() == 1) { $correctCredit365 = ($term-7)*0.015;}
            if($shop->getId() == 7) { $correctCreditUp = -1;}            
            $shop->commision = ($shop->getfirstPercent()-$correctCredit365)*($term+$correctCreditUp)*$money*(100-$shop->getfirstDiscount())/100/100;
        }
        uasort($group1,array($this, "mySort"));
        $group2 = $this->getDoctrine()->getRepository('AppBundle:Proposition')->getNextGroup($money,$term);
        foreach($group2 as $shop){
            $correctCredit365 = 0; 
            $correctCreditUp = 0;
            if($shop->getId() == 1) { $correctCredit365 = ($term-7)*0.015;}
            if($shop->getId() == 7) { $correctCreditUp = -1;}            
            $shop->commision = ($shop->getfirstPercent()-$correctCredit365)*($term+$correctCreditUp)*$money/100;
        }
        uasort($group2,array($this, "mySort"));
        $group3 = $this->getDoctrine()->getRepository('AppBundle:Proposition')->getLastGroup($money,$term);
        foreach($group3 as $shop){
            $correctCredit365 = 0; 
            $correctCreditUp = 0;
            if($shop->getId() == 1) { $correctCredit365 = ($term-7)*0.015;}
            if($shop->getId() == 7) { $correctCreditUp = -1;}            
            $shop->commision = ($shop->getfirstPercent()-$correctCredit365)*($term+$correctCreditUp)*$money/100;
        }
        uasort($group3,array($this, "mySort"));
        return $this->render('ajax.html.twig', array("group1" => $group1, "group2" => $group2, "group3" => $group3, "money"=> $money, "term"=>$term));
    }

    /**
     * @Route("/service/{id}", name="service")
     */    
    public function serviceAction($id)
    {
        $service = $this->getDoctrine()->getRepository('AppBundle:Proposition')->findOneById($id);
        return $this->render('service.html.twig', array('shop'=>$service, 'title'=>$service->getCompany()));
    }
    
    /**
     * @Route("/howto", name="howto")
     */    
    public function howtoAction()
    {
        $shops = $this->getDoctrine()->getRepository('AppBundle:Proposition')->getShops();
        return $this->render('howto.html.twig',array('shops'=>$shops, 'title'=>'Как это работает'));
    }    
    
    /**
     * @Route("/mainmenu", name="mainmenu")
     */    
    public function mainmenuAction()
    {
        $shops = $this->getDoctrine()->getRepository('AppBundle:Proposition')->getShops();
        return $this->render('blocks/mainmenu.html.twig',array('shops'=>$shops));
    }    
    
    /**
     * @Route("/slider", name="slider")
     */    
    public function sliderAction()
    {
        $shops = $this->getDoctrine()->getRepository('AppBundle:Proposition')->getShops();
        return $this->render('blocks/slider.html.twig',array('shops'=>$shops));
    }    

    /**
     * @Route("/addcomment", name="addcomment")
     */    
    public function addcommentAction()
    {
        //date_default_timezone_set('Europe/Kiev'); 
        $user = $_POST['user'];
        $mail = $_POST['mail'];
        $msg = $_POST['msg'];
        $service = $_POST['service'];
        $rating = $_POST['rating'];
        $proposition = $this->getDoctrine()->getRepository('AppBundle:Proposition')->find($service);
        $this->getDoctrine()->getRepository('AppBundle:Comments')->addComment($user,$mail,$msg,$rating,$service,$proposition);
        return $this->redirectToRoute('service', array('id' => $service));
    }    
    
    /**
     * @Route("/addsubscriber", name="addsubscriber")
     */    
    public function addsubscriberAction()
    {
        $user = $_POST['user'];
        $mail = $_POST['mail'];
        $tel = $_POST['tel'];
        $route = $_POST['route'];
        try{
          $this->getDoctrine()->getRepository('AppBundle:Subscriber')->addSubscriber($user,$mail,$tel);
        }catch(\Exception $e){
        }finally{
            return $this->redirect($route);
        }
    }    
    
    /**
     * @Route("/redirect", name="redirect")
     */    
    public function redirectAction()
    {
        $condition = $_POST['conditions']; 
        $type = $_POST['type']; 
        return $this->redirect('/'.$type.'/'.$condition);
    }       
    
    /**
     * @Route("/{type}/{condition}", name="condition")
     */    
    public function conditionAction($type, $condition)
    {
        $article = $this->getDoctrine()->getRepository('AppBundle:Articles')->findOneById($type.'/'.$condition);
        return $this->render('index.html.twig',array('title'=>$article->getTitle(),'article'=>$article));    
    }    
    
}

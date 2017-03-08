<?php

namespace AppBundle\Controller;

use Symfony\Component\DependencyInjection\Reference;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Comments;
use AppBundle\Entity\Subscriber;

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
        // Перевірити регуіред
        $subscriber = new Subscriber();
        $form = $this->createFormBuilder($subscriber)
                ->add('user')
                ->add('mail')
                ->add('tel')
                ->add('submit', SubmitType::class)
                ->getForm();
        $article = $this->getDoctrine()
                   ->getRepository('AppBundle:Articles')
                   ->findOneById('/');
        return $this->render('index.html.twig',array('title'=>$article->getTitle(),'article'=>$article,'form'=>$form->createView()));
    }
    
    public function mySort($f1,$f2)
   {
      if(($f1->getRecomended() > 0) || ($f2->getRecomended() > 0)){
          if(($f1->getRecomended() > $f2->getRecomended())) {return -1;} else {return 1;}
      }
      if($f1->commision < $f2->commision) return -1;
      elseif($f1->commision > $f2->commision) return 1;
      else return 0;
   }

    /**
     * @Route("/calc/{money}/{term}", name="calc")
     */    
    public function calcAction($money=2000, $term=30)
    {
        $group1 = $this->getDoctrine()
                  ->getRepository('AppBundle:Proposition')
                  ->getFirstGroup($money,$term);
        foreach($group1 as $shop){
            $correctCredit365 = 0; 
            $correctCreditUp = 0;
            if($shop->getId() == 1) { $correctCredit365 = ($term-7)*0.015;}
            if($shop->getId() == 7) { $correctCreditUp = -1;}            
            $shop->commision = ($shop->getfirstPercent()-$correctCredit365)*($term+$correctCreditUp)*$money*(100-$shop->getfirstDiscount())/100/100+$shop->getCommision1()+$shop->getCommision2()*$money;
        }
        uasort($group1,array($this, "mySort"));
        $group2 = $this->getDoctrine()->getRepository('AppBundle:Proposition')->getNextGroup($money,$term);
        foreach($group2 as $shop){
            $correctCredit365 = 0; 
            $correctCreditUp = 0;
            if($shop->getId() == 1) { $correctCredit365 = ($term-7)*0.015;}
            if($shop->getId() == 7) { $correctCreditUp = -1;}            
            $shop->commision = ($shop->getnextPercent()-$correctCredit365)*($term+$correctCreditUp)*$money/100+$shop->getCommision1()+$shop->getCommision2()*$money;
        }
        uasort($group2,array($this, "mySort"));
        $group3 = $this->getDoctrine()->getRepository('AppBundle:Proposition')->getLastGroup($money,$term);
        foreach($group3 as $shop){
            $correctCredit365 = 0; 
            $correctCreditUp = 0;
            if($shop->getId() == 1) { $correctCredit365 = ($term-7)*0.015;}
            if($shop->getId() == 7) { $correctCreditUp = -1;}            
            $shop->commision = ($shop->getnextPercent()-$correctCredit365)*($term+$correctCreditUp)*$money/100+$shop->getCommision1()+$shop->getCommision2()*$money;
        }
        uasort($group3,array($this, "mySort"));
        return $this->render('ajax.html.twig', array("group1" => $group1, "group2" => $group2, "group3" => $group3, "money"=> $money, "term"=>$term));
    }

    /**
     * @Route("/service/{id}", name="service")
     */    
    public function serviceAction($id)
    {
        $service = $this->getDoctrine()
                   ->getRepository('AppBundle:Proposition')
                   ->findOneById($id);
        $comments = new Comments();
        $comments->setCompanyId($service);
        $form = $this->createFormBuilder($comments)
                ->add('user')
                ->add('mail')
                ->add('rank')
                ->add('companyid', EntityType::Class,array( 'class' => "AppBundle\Entity\Proposition",'choice_label' => 'id'))
                ->add('msg')
                ->add('submit', SubmitType::class)
                ->getForm();
        return $this->render('service.html.twig', array('shop'=>$service, 'title'=>$service->getCompany(), 'form' => $form->createView()));
    }
    
    /**
     * @Route("/howto", name="howto")
     */    
    public function howtoAction()
    {
        $subscriber = new Subscriber();
        $form = $this->createFormBuilder($subscriber)
                ->add('user')
                ->add('mail')
                ->add('tel')
                ->add('submit', SubmitType::class)
                ->getForm();
        $shops = $this->getDoctrine()
                 ->getRepository('AppBundle:Proposition')
                 ->getShops();
        return $this->render('howto.html.twig',array('shops'=>$shops, 'title'=>'Как это работает', 'form'=>$form->createView()));
    }    
    
    /**
     * @Route("/mainmenu", name="mainmenu")
     */    
    public function mainmenuAction()
    {
        $shops = $this->getDoctrine()
                 ->getRepository('AppBundle:Proposition')
                 ->getShops();
        return $this->render('blocks/mainmenu.html.twig',array('shops'=>$shops));
    }    
    
    /**
     * @Route("/slider", name="slider")
     */    
    public function sliderAction()
    {
        $shops = $this->getDoctrine()
                 ->getRepository('AppBundle:Proposition')
                 ->getShops();
        return $this->render('blocks/slider.html.twig',array('shops'=>$shops));
    }    

    /**
     * @Route("/addcomment", name="addcomment")
     */    
    public function addcommentAction(Request $request)
    {
        //date_default_timezone_set('Europe/Kiev'); 

        $comment = new Comments();
        $form = $this->createFormBuilder($comment)
                ->add('user')
                ->add('mail')
                ->add('rank')
                ->add('companyid', EntityType::Class,array( 'class' => "AppBundle\Entity\Proposition",'choice_label' => 'id'))
                ->add('msg')
                ->add('submit', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        $comment = $form->getData();         
        $response = new Response();
        $response->headers->setCookie(new Cookie('mail', $comment->getMail(), strtotime('now + 1 day')));
        $response->headers->setCookie(new Cookie('user', $comment->getUser(), strtotime('now + 1 day')));
        $response->sendHeaders();
        $this->getDoctrine()
        ->getRepository('AppBundle:Comments')
        ->addComment($comment);
        return $this->redirectToRoute('service', array('id' => $comment->getCompanyId()->getId()));
    }    
    
    /**
     * @Route("/addsubscriber", name="addsubscriber")
     */    
    public function addsubscriberAction(Request $request)
    {
        $subscriber = new Subscriber();
        $form = $this->createFormBuilder($subscriber)
                ->add('user')
                ->add('mail')
                ->add('tel')
                ->add('submit', SubmitType::class)
                ->getForm();
        $form->handleRequest($request);
        $subscriber = $form->getData();         
        $response = new Response();
        $response->headers->setCookie(new Cookie('mail', $subscriber->getMail(), strtotime('now + 1 day')));
        $response->headers->setCookie(new Cookie('user', $subscriber->getUser(), strtotime('now + 1 day')));
        $response->headers->setCookie(new Cookie('tel', $subscriber->getTel(), strtotime('now + 1 day')));
        $response->sendHeaders();
        try{
        $this->getDoctrine()
        ->getRepository('AppBundle:Subscriber')
        ->addSubscriber($subscriber);
        }catch(\Exception $e){
        }finally{
            return $this->redirect($request->server->get('HTTP_REFERER'));
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
        $subscriber = new Subscriber();
        $form = $this->createFormBuilder($subscriber)
                ->add('user')
                ->add('mail')
                ->add('tel')
                ->add('submit', SubmitType::class)
                ->getForm();
        $article = $this->getDoctrine()
                   ->getRepository('AppBundle:Articles')
                   ->findOneById($type.'/'.$condition);
        return $this->render('index.html.twig',array('title'=>$article->getTitle(),'article'=>$article, 'form'=>$form->createView()));    
    }    
    
}

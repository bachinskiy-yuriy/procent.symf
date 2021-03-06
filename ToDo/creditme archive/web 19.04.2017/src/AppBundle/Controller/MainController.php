<?php

namespace AppBundle\Controller;

use Symfony\Component\DependencyInjection\Reference;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Comments;
use AppBundle\Entity\Proposition;
use AppBundle\Entity\About;
use AppBundle\Entity\Contact;
use AppBundle\Entity\Articles;
use AppBundle\Entity\Subscriber;
use AppBundle\Entity\Post;

class MainController extends Controller
{    

    /**
     * @Route("tst", name="tst")
     */
    public function tstAction()
    {
        $em = $this->getDoctrine()->getManager();  // получаем менеджер сущностей из внутри контроллера
        $post = new Post;
        $post->setTitle('название на русском');
        $post->setContent('контент на русском');
        $em->persist($post);
        $em->flush();
        $subscriber = new Subscriber();
        $form = $this->getForm($subscriber);         
        $article = $this->getDoctrine()
                   ->getRepository('AppBundle:Articles')
                   ->findOneById('/');
        return $this->render('index.html.twig',array('title'=>$article->getTitle(),'meta'=>$article->getMeta(),'article'=>$article,'form'=>$form->createView()));
    }
    /**
     * @Route("tst2", name="tst2")
     */
    public function tst2Action()
    {
        $em = $this->getDoctrine()->getManager();
        $postId = 1;
        $post = $em->find('AppBundle\Entity\Post', $postId);
        $post->setTitle('название на английском');
        $post->setContent('контент на английском');
        $post->setTranslatableLocale('en_GB'); // изменяем локаль
        $em->persist($post);
        $em->flush();
        $subscriber = new Subscriber();
        $form = $this->getForm($subscriber);         
        $article = $this->getDoctrine()
                   ->getRepository('AppBundle:Articles')
                   ->findOneById('/');
        return $this->render('index.html.twig',array('title'=>$article->getTitle(),'meta'=>$article->getMeta(),'article'=>$article,'form'=>$form->createView()));
    }

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
    public function indexAction(Request $request)
    {
        $subscriber = new Subscriber();
        $form = $this->getForm($subscriber);         
        $article = $this->getDoctrine()
                   ->getRepository('AppBundle:Articles')
                   ->findOneById('/');
        return $this->render('index.html.twig',array('title'=>$article->getTitle(),'meta'=>$article->getMeta(),'article'=>$article,'form'=>$form->createView()));
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
    
    public function getCommision($service,$term,$money,$group)
    {
        $correctCredit365 = 0; 
        $correctCreditUp = 0;
        if($service->getId() == 1) { $correctCredit365 = ($term-7)*0.015;}
        if($service->getId() == 7) { $correctCreditUp = -1;}            
        switch($group){
            case 1: $service->commision = ($service->getfirstPercent()-$correctCredit365)*($term+$correctCreditUp)*$money*(100-$service->getfirstDiscount())/100/100+$service->getCommision1()+$service->getCommision2()*$money;
            break;
            case 2: $service->commision = ($service->getnextPercent()-$correctCredit365)*($term+$correctCreditUp)*$money/100+$service->getCommision1()+$service->getCommision2()*$money;
            break;
            case 3: $service->commision = ($service->getnextPercent()-$correctCredit365)*($term+$correctCreditUp)*$money/100+$service->getCommision1()+$service->getCommision2()*$money;
        }        
        return $service;
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
            $shop = $this -> getCommision($shop,$term,$money,1);
        }
        uasort($group1,array($this, "mySort"));
        $group2 = $this->getDoctrine()
                  ->getRepository('AppBundle:Proposition')
                  ->getNextGroup($money,$term);
        foreach($group2 as $shop){
            $shop = $this -> getCommision($shop,$term,$money,2);
        }
        uasort($group2,array($this, "mySort"));
        $group3 = $this->getDoctrine()
                  ->getRepository('AppBundle:Proposition')
                  ->getLastGroup($money,$term);
        foreach($group3 as $shop){
            $shop = $this -> getCommision($shop,$term,$money,3);
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
        $service = $this->getCommision($service,7,1000,1);
        $comments = new Comments();
        $comments->setCompanyId($service);
        $form = $this->getForm($comments);         
        return $this->render('service.html.twig', array('shop'=>$service, 'title'=>$service->getCompany(), 'form' => $form->createView()));
    }
    
    /**
    * @Route("/{serviceslug}", name="shop")
    */    
    public function shopAction($serviceslug)
    {
        $service = $this->getDoctrine()
                   ->getRepository('AppBundle:Proposition')
                   ->findOneBySlug($serviceslug);
        $service = $this->getCommision($service,7,1000,1);
        $comments = new Comments();
        $comments->setCompanyId($service);
        $form = $this->getForm($comments);         
        return $this->render('service.html.twig', array('shop'=>$service, 'title'=>$service->getCompany(), 'form' => $form->createView()));
    }  

    
    /**
     * @Route("/howto/", name="howto")
     */    
    public function howtoAction()
    {
        $subscriber = new Subscriber();
        $form = $this->getForm($subscriber);         
        $shops = $this->getDoctrine()
                 ->getRepository('AppBundle:Proposition')
                 ->getShops();
        return $this->render('howto.html.twig',array('shops'=>$shops, 'form'=>$form->createView()));
    }    
    
    /**
     * @Route("/mainmenu/{ua}/{ru}", name="mainmenu")
     */    
    public function mainmenuAction($ua='ua',$ru='ru')
    {
        $shops = $this->getDoctrine()
                 ->getRepository('AppBundle:Proposition')
                 ->getShops();
        return $this->render('blocks/mainmenu.html.twig',array('shops'=>$shops, 'ua'=>$ua, 'ru'=>$ru));
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
        $form = $this->getForm($comment); 
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
        $form = $this->getForm($subscriber); 
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
    public function redirectAction(Request $request)
    {
        $condition = $_POST['conditions']; 
        $type = $_POST['type']; 
        // return $this->redirect('/'.$type.'/'.$condition);
        return $this->redirectToRoute('condition',array('type'=>$type,'condition'=>$condition,'_locale'=>$request->getLocale()));
    }       
    
    /**
     * @Route("/{type}/{condition}", name="condition")
     */    
    public function conditionAction($type, $condition)
    {
        $subscriber = new Subscriber();
        $form = $this->getForm($subscriber); 
        $article = $this->getDoctrine()
                   ->getRepository('AppBundle:Articles')
                   ->findOneById($type.'/'.$condition);
        return $this->render('index.html.twig',array('title'=>$article->getTitle(),'meta'=>$article->getMeta(),'article'=>$article, 'form'=>$form->createView()));    
    }  

    public function getForm($entity)
    {
        if($entity instanceof Subscriber){
            $form =  $this->createFormBuilder($entity)
                     ->add('user')
                     ->add('mail')
                     ->add('tel')
                     ->add('submit', SubmitType::class)
                     ->getForm();
        }        
        if($entity instanceof Comments){
            $form = $this->createFormBuilder($entity)
                    ->add('user')
                    ->add('mail')
                    ->add('rank')
                    ->add('companyid', EntityType::Class,array( 'class' => "AppBundle\Entity\Proposition",'choice_label' => 'id'))
                    ->add('msg')
                    ->add('submit', SubmitType::class)
                    ->getForm();
        } 
        return $form;        
    }   
}
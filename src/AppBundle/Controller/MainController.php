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
        // $shops = $this->getDoctrine()->getRepository('AppBundle:Creditonline')->getShops();
        $shops = $this->getDoctrine()->getRepository('AppBundle:Proposition')->getShops();
        return $this->render('index.html.twig',array('shops'=>$shops, 'title'=>'Лучший кредит'));
    }

    /**
     * @Route("/calc/{money}/{term}", name="calc")
     */    
    public function calcAction($money=2000, $term=30)
    {
        // $shops = $this->getDoctrine()->getRepository('AppBundle:Creditonline')->getFilteredShops($money,$term);
        $shops = $this->getDoctrine()->getRepository('AppBundle:Proposition')->getFilteredShops($money,$term);
        return $this->render('ajax.html.twig', array("shops" => $shops, "money"=> $money, "term"=>$term));
    }

    /**
     * @Route("/service/{id}", name="service")
     */    
    public function serviceAction($id)
    {
        $service = $this->getDoctrine()->getRepository('AppBundle:Proposition')->findOneByIdWithContact($id);
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
    
}

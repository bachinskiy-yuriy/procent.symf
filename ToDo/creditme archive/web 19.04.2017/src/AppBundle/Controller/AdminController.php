<?php

namespace AppBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Comments;
use AppBundle\Entity\Proposition;
use AppBundle\Entity\About;
use AppBundle\Entity\Contact;
use AppBundle\Entity\Articles;
use AppBundle\Entity\Subscriber;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class AdminController extends BaseAdminController
{       
    public function createNewUsersEntity()
    {
        return $this->get('fos_user.user_manager')->createUser();
    }

    public function prePersistUsersEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }    
    
    public function preUpdateUsersEntity($user)
    {
        $this->get('fos_user.user_manager')->updateUser($user, false);
    }
    
    /**
     * @Route("admin/import", name="import")
     */
    public function importAction()
    {
        $files = array();
        if(isset($_FILES['Info'])){
            if(file_exists($_FILES['Info']['tmp_name']) && is_uploaded_file($_FILES['Info']['tmp_name'])){
                $handle = fopen($_FILES['Info']['tmp_name'], "r");
                while (($data = fgetcsv($handle, 5000, ",",'"')) !== FALSE) {
                   try
                   {
                        $info = New About();
                        $info = $this->getDoctrine()
                                     ->getRepository('AppBundle:About')
                                     ->findOneBycompanyid($data[0]);
                        if(isset($info)){$info->setArticle($data[1]);}
                        // $files[] = 'SUCCESS '.$data[0].' '.$data[1];
                    }catch(\Exception $e){ $files[] = 'FAILED '.$data[0].' '.$data[1]; }
                }    
            }
            if(file_exists($_FILES['Comments']['tmp_name']) && is_uploaded_file($_FILES['Comments']['tmp_name'])){
                $handle = fopen($_FILES['Comments']['tmp_name'], "r");
                $row = 0;
                while (($data = fgetcsv($handle, 5000, ",",'"')) !== FALSE) {
                   $row++;
                   try {
                        $p = New Proposition();
                        $p = $this->getDoctrine()
                             ->getRepository('AppBundle:Proposition')
                             ->findOneById($data[0]);
                        if(!isset($p)) throw new NotFoundHttpException("Object not found");
                        $info = New Comments();
                        if(isset($info)){
                            $info->setCompanyId($p);                        
                            $info->setUser($data[1]);
                            $info->setMail($data[2]);
                            $info->setRank($data[3]);
                            $info->setMsg($data[4]);
                            $info->setPublDate(date_create($data[5]));
                            $info->setModerate($data[6]);
                        }
                        $p->addComment($info);
                        $files[] = "<font color='green'>row $row entity Comment load succesfully</font>";
                    }catch(\Exception $e){ $files[] = "<font color='red'>row $row entity Comment failed to load</font>"; }                   
                }
            }
            if(file_exists($_FILES['Contacts']['tmp_name']) && is_uploaded_file($_FILES['Contacts']['tmp_name'])){
                $handle = fopen($_FILES['Contacts']['tmp_name'], "r");
                $row = 0;
                while (($data = fgetcsv($handle, 5000, ",")) !== FALSE) {
                   $row++;
                   try {
                        $p = New Proposition();
                        $p = $this->getDoctrine()
                             ->getRepository('AppBundle:Proposition')
                             ->findOneById($data[0]);
                        if(!isset($p)) throw new NotFoundHttpException("Object not found");
                        $info = New Contact();
                        if(isset($info)){
                            $info->setCompanyId($p);                        
                            $info->setKey($data[1]);
                            $info->setValue($data[2]);
                        }
                        $p->addContact($info);
                        $files[] = "<font color='green'>row $row entity Contact load succesfully</font>";
                    }catch(\Exception $e){ $files[] = "<font color='red'>row $row entity Contact failed to load</font>"; }                   
                }
            }
            // Створення нових Статей // добавити поле ІД. поточне ід перейменувати на слаг
            if(file_exists($_FILES['Articles']['tmp_name']) && is_uploaded_file($_FILES['Articles']['tmp_name'])){
                $handle = fopen($_FILES['Articles']['tmp_name'], "r");
                $row = 0;
                while (($data = fgetcsv($handle, 5000, ",")) !== FALSE) {
                   $row++;
                   try {
                        $info = $this->getDoctrine()
                                ->getRepository('AppBundle:Articles')
                                ->findOneById($data[0]);
                        if(!isset($info)) { 
                            $info = New Articles();//throw new NotFoundHttpException("Object not found");
                            $info->setId($data[0]);
                        }    
                        $info->setTitle($data[1]);
                        $info->setArticle($data[2]);
                        $this->getDoctrine()
                             ->getRepository('AppBundle:Articles')
                             ->addArticle($info);
                        $files[] = "<font color='green'>row $row entity Article load succesfully</font>";
                    }catch(\Exception $e){ $files[] = "<font color='red'>row $row entity Article failed to load</font>"; }                   
                }
            }
            if(file_exists($_FILES['Subscribers']['tmp_name']) && is_uploaded_file($_FILES['Subscribers']['tmp_name'])){
                $handle = fopen($_FILES['Subscribers']['tmp_name'], "r");
                $row = 0;
                while (($data = fgetcsv($handle, 5000, ",")) !== FALSE) {
                    $row++;
                   try {
                        $info = New Subscriber();   
                        $info->setUser($data[0]);
                        $info->setMail($data[1]);
                        $info->setTel($data[2]);
                        $info->setSubscribeDate(date_create($data[3]));
                        $this->getDoctrine()
                             ->getRepository('AppBundle:Subscriber')
                             ->addSubscriber($info);
                        $files[] = "<font color='green'>row $row entity Subscriber load succesfully</font>";
                    }catch(\Exception $e){ $files[] = "<font color='red'>row $row entity Subscriber failed to load</font>"; }                   
                }
            }
            if(file_exists($_FILES['Propositions']['tmp_name']) && is_uploaded_file($_FILES['Propositions']['tmp_name'])){
                $handle = fopen($_FILES['Propositions']['tmp_name'], "r");
                while (($data = fgetcsv($handle, 5000, ",",'"')) !== FALSE) {
                   try
                   {
                        $p = New Proposition();
                        $p = $this->getDoctrine()
                             ->getRepository('AppBundle:Proposition')
                             ->findOneById($data[0]);
                        if(isset($p)){
                            $p->setCompany($data[1]);
                            $p->setSite($data[2]);
                            $p->setLanding($data[3]);
                            $p->setDayMin($data[4]);
                            $p->setSumMin($data[5]);
                            $p->setFirstDayMax($data[6]);
                            $p->setFirstSumMax($data[7]);
                            $p->setFirstPercent($data[8]);
                            $p->setFirstDiscount($data[9]);
                            $p->setNextDayMax($data[10]);
                            $p->setNextSumMax($data[11]);
                            $p->setNextPercent($data[12]);
                            $p->setCommision1($data[13]);
                            $p->setCommision2($data[14]);
                            $p->setRoundType($data[15]);
                            $p->setImg($data[16]);
                            $p->setRecomended($data[17]);
                        }
                        if(!isset($p)) throw new NotFoundHttpException("Object not found");
                        $this->getDoctrine()
                             ->getRepository('AppBundle:Proposition')
                             ->addProposition($p);
                        $files[] = 'SUCCESS '.$data[0].' '.$data[1];
                    }catch(\Exception $e){ $files[] = 'FAILED '.$data[0].' '.$data[1]; }                   
                }
            }

            try {
                $this->getDoctrine()->getRepository('AppBundle:Comments')->Commit();
                $file[] = "<font color='green'>uploaded successfully</font>";
            }catch(\Exception $e){ $files[] = "<font color='red'>failed to upload</font><br>".$e->getMessage(); }
        }
        // foreach($_FILES as $file){
            // if(file_exists($file['tmp_name']) && is_uploaded_file($file['tmp_name'])) 
            // {
               // if($file['name'] == 'Propo')
               // $files[] = $file['name'].' successfully uploaded';
            // }
        // }    
        return $this->render('test.html.twig', array('csv' => $files));
    }
    
}
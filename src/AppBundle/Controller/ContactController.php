<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\LoginType;
use AppBundle\Form\ContactType;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contactpage")
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $create = $form ->getData();
            $contact = new Contact();
            $contact ->setName($create['name']);
            $contact ->setSubject($create['subject']);
            $contact ->setMessage($create['message']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
        }
        $res_array=array('form'=>$form->createView());
        $res_array['isLogin']=false;
        $session=$request->getSession();
        if($session->has('login')){
            $res_array['isLogin']=true;
        }

        $repository = $this->getDoctrine()->getRepository('AppBundle:Category');
        $cates = $repository->findAll();
        $res_array['cates'] = $cates;

        $repository = $this->getDoctrine()->getRepository('AppBundle:Brand');
        $brands = $repository->findAll();
        $res_array['brands'] = $brands;
        $res_array['title'] = "Contact";
        return $this->render('default/contact.html.twig',$res_array);
    }

}
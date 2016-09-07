<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\LoginType;
use AppBundle\Form\RegisterType;

class ProfileController extends Controller
{
    /**
     * @Route("/profile", name="profilepage")
     */
    public function indexAction(Request $request)
    {
        $res_array=array();
        $res_array['isLogin']=false;
        $session=$request->getSession();
        if($session->has('login')){
            $res_array['isLogin']=true;
        }
        $repository = $this->getDoctrine()->getRepository('AppBundle:Brand');
        $brands = $repository->findAll();
        $res_array['brands'] = $brands;

        $repository = $this->getDoctrine()->getRepository('AppBundle:Category');
        $cates = $repository->findAll();
        $res_array['cates'] = $cates;

        $repository = $this->getDoctrine()->getRepository('AppBundle:User');
        $user = $repository->find($session->get('id'));
        $res_array['user'] = $user;
        $res_array['title'] = "Profile";

        return $this->render('default/profile.html.twig',$res_array);
    }
}
<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\LoginType;
use AppBundle\Form\RegisterType;

class CategoryController extends Controller
{
    /**
     * @Route("/category/{id}", name="categoryproduct")
     */
    public function indexAction($id,Request $request)
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

        $cat = $repository->find($id);
        $res_array['cat'] =$cat;
        return $this->render('default/categoryproduct.html.twig',$res_array);
    }
}
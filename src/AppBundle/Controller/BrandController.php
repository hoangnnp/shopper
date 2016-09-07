<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\LoginType;
use AppBundle\Form\RegisterType;

class BrandController extends Controller
{
    /**
     * @Route("/brand/{id}", name="brandproduct")
     */
    public function indexAction($id,Request $request)
    {
        $res_array=array();
        $res_array['isLogin']=false;
        $session=$request->getSession();
        if($session->has('login')){
            $res_array['isLogin']=true;
        }

        $repository = $this->getDoctrine()->getRepository('AppBundle:Category');
        $catess = $repository->findAll();
        $res_array['catess'] = $catess;

        $repository = $this->getDoctrine()->getRepository('AppBundle:Brand');
        $brands = $repository->findAll();
        $res_array['brands'] = $brands;
        $bra = $repository->find($id);
        $res_array['bra'] =$bra;

        $repository = $this->getDoctrine()->getRepository('AppBundle:Product');
        $featuredProducts =  $repository->findBy(array('isFeatured'=>true));
        $res_array['featuredProducts'] = $featuredProducts;

        return $this->render('default/brandProduct.html.twig',$res_array);
    }
}
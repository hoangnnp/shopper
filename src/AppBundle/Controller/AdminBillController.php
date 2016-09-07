<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\LoginType;
use AppBundle\Form\RegisterType;

class AdminBillController extends Controller
{
    /**
     * @Route("/admin/bill", name="billproduct")
     */
    public function billAction(Request $request)
    {
        $res_array=array();
        $se = $request->getSession();
        if (!$se->has('login')) {
            return $this->render('errorlogin.html.twig');
        }
        $repository = $this->getDoctrine()->getRepository('AppBundle:bill');
        $bills = $repository->findAll();
        $res_array['bill'] = $bills;
        return $this->render('admin/bill.html.twig',$res_array);
    }
    /**
     * @Route("/admin/bill/detail/{id}", name="billdetailproduct")
     */
    public function billdetailAction($id,Request $request)
    {
        $res_array=array();
        $se = $request->getSession();
        if (!$se->has('login')) {
            return $this->render('errorlogin.html.twig');
        }
        $repository = $this ->getDoctrine() ->getRepository('AppBundle:bill');
        $bills=$repository->findOneBy(array('id'=>$id));
        $res_array['bill'] = $bills;
        return $this->render('admin/billdetail.html.twig',$res_array);
    }
    /**
     * @Route("/admin/bill/edit/{id}", name="billeditproduct")
     */
    public function billeditAction($id,Request $request)
    {

        $se = $request->getSession();
        if (!$se->has('login')) {
            return $this->render('errorlogin.html.twig');
        }
        $em=$this->getDoctrine()->getManager();
        $bill = $em->find('AppBundle\Entity\bill',$id);
        $bill ->setOrderstate("Confirmed");
        $em->persist($bill);
        $em->flush();
        return $this->redirectToRoute("billproduct");
    }
}
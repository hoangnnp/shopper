<?php

namespace AppBundle\Controller;

use AppBundle\Entity\bill;
use AppBundle\Entity\detailbill;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\LoginType;
use AppBundle\Form\RegisterType;

class CartController extends Controller
{
    /**
     * @Route("/cart", name="cartpage")
     */
    public function cartAction(Request $request)
    { $res_array=array();
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

        //lấy bill của người dùng
        $repository = $this->getDoctrine()->getRepository('AppBundle:bill');
        $repositoryUser = $this->getDoctrine()->getRepository('AppBundle:User');
        $session = $request->getSession();
        $user_id =$session->get('id');
        $user=$repositoryUser->find($user_id);
        $bill = $repository->findOneBy(array('user'=>$user,'orderstate'=>'Pending'));//chỉ lấy order đang pending
        $res_array['bill'] = $bill;
        $res_array['title'] = "Cart";

        return $this->render('default/cart.html.twig',$res_array);
    }
    /**
     * @Route("/cart/{id}", name="cartproduct")
     */
    public function addToCartAction($id,Request $request)
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
        //tìm xem có order cũ ko, nếu chưa thìtaojo order mới để lưu thông tin
        $repository = $this->getDoctrine()->getRepository('AppBundle:bill');
        $repositoryUser = $this->getDoctrine()->getRepository('AppBundle:User');
        $repositoryProduct = $this->getDoctrine()->getRepository('AppBundle:Product');
        $session = $request->getSession();
        $user_id =$session->get('id');
        $user=$repositoryUser->find($user_id);

        $bill = $repository->findOneBy(array('user'=>$user,'orderstate'=>'Pending'));
        if($bill==null)//nếu ko tìm được
        {
            //tạo bill mới
            $bill = new bill();
            $bill ->setOrdercost(0);
            $bill->setOrderstate("Pending");
            $bill->setOrderdate(new \DateTime("now"));
            $bill->setUser($user);
            $em=$this->getDoctrine()->getManager();
            $em->persist($bill);
            $em->flush();
        }

        //sau khi có bill (có thể là bill củ hoặc bill mới tạo)

        //lấy ds chi tiết bill (1)
        $details = $bill->getDetailbillss();

        //tìm product theo id người dùng gửi lên
        $product=$repositoryProduct->find($id);

        //tạo biến bill_detail = null, tạo tạm để kiếm tra sau
        $bill_detail=null;

        //duyệt mảng $details để tìm cái detail nào có product = với product mà usser gửi lên
        foreach($details as $detail)
        {
           if($detail->getProduct() == $product)
           {
               $bill_detail = $detail; // tìm thấy thì lưu vô biến #
               break;
           }
        }

        if($bill_detail!=null)
        {
            $bill_detail->setQuantity($bill_detail->getQuantity()+1);
            $em=$this->getDoctrine()->getManager();
            $em->persist($bill_detail);
            $em->flush();
        }else{
            $bill_detail=new detailbill();
            $bill_detail->setBill($bill);
            $bill_detail->setProduct($product);
            $bill_detail->setQuantity(1);
            $em=$this->getDoctrine()->getManager();
            $em->persist($bill_detail);
            $em->flush();
        }

        //tạm thời ac cho nó về trang chủ hen ok
        return $this->redirectToRoute("homepage");
    }
    /**
     * @Route("cart/{id}/delete",name="deletecart")
     */
    public function deletecartAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $cart = $em->getPartialReference('AppBundle\Entity\detailbill', array('id' => $id));
        $em->remove($cart);
        $em->flush();
        return $this->redirectToRoute("cartpage");
    }
    /**
     * @Route("order/{id}/checkout",name="checkout_order")
     */
    public function deleteorderAction($id)
    {
        //a bị sai ỏ đâu ròi
        $em=$this->getDoctrine()->getManager();

        $cart = $em->find('AppBundle\Entity\bill',  $id);
        $cost=0;
        foreach($cart->getDetailbillss() as $d)
        {
            $c = $d->getQuantity()*$d->getProduct()->getPrice();
            $cost=$cost+$c;
        }
        $cart->setOrdercost($cost);
        $cart->setOrderstate("Ordered");
        $em->persist($cart);
        $em->flush();
        return $this->redirectToRoute("homepage");
    }

}
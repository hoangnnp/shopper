<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\LoginType;
use AppBundle\Form\RegisterType;

class DefaultController extends Controller
{
    /**
     * @Route("/product/{id}/detail", name="detailproduct")
     */
    public function detailAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
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
        $catess = $repository->findAll();
        $res_array['catess'] = $catess;


        $detailp = $em->find('AppBundle:Product',$id);
        $res_array['product']=$detailp;
        $res_array['title'] = "Product Detail";

        return $this->render('default/detailProduct.html.twig',$res_array);
    }
    /**
     * @Route("/", name="homepage")
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
        $catess = $repository->findAll();
        $res_array['catess'] = $catess;

        $repository = $this->getDoctrine()->getRepository('AppBundle:Poster');
        $posters = $repository->findAll();
        $res_array['posters'] = $posters;

        $repository = $this->getDoctrine()->getRepository('AppBundle:Product');
        $featuredProducts =  $repository->findBy(array('isFeatured'=>true));
        $res_array['featuredProducts'] = $featuredProducts;

        $res_array['title'] = "Home";
        return $this->render('default/index.html.twig',$res_array);
    }

    /**
     * @Route("/lang/{name}", name="changeLang")
     */
    public function changeLangAction($name, Request $request)
    {
        $se = $request->getSession();
        $se->set('locate',$name);
        return $this->redirectToRoute('homepage');
    }
    /**
     * @Route("/login", name="loginpage")
     */
    public function loginAction(Request $request)
    {
        $form=$this->createForm(LoginType::class);
        $form->handleRequest($request);
            if($form->isSubmitted()& $form->isValid()){
            $login = $form ->getData();
                $repository=$this->getDoctrine()->getRepository('AppBundle:User');
                $user=$repository->findOneBy(array('username'=>$login['username'],'password'=>$login['password']));
                if($user!=null){
                   $session = $request ->getSession();
                    $session->set('username',$user->getUsername());
                    $session->set('url',$user->getUrl());
                    $session->set('fullname',$user->getFullname());
                    $session->set('id',$user->getId());
                    $session->set('role',$user->getRole());
                    $session->set('login',true);
                    if($user->getRole()=='Normal')
                        return $this->redirectToRoute('homepage');
                    if($user->getRole()=='Admin')
                        return $this->redirectToRoute('adminpage');
                }
        }
        $form2=$this->createForm(RegisterType::class);
        $form2->handleRequest($request);
        if($form2->isSubmitted()&& $form2->isValid()) {
            $create = $form2->getData();
            $user = new User();
            $user->setUsername($create['username']);

            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $create['password']);

            $user->setPassword($password);
            $user->setFullname($create['fullname']);
            $user->setUrl('Null');
            $user->setRole('Normal');
            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
        }
        $res_array=array('form1'=>$form->createView(),'form2'=>$form2->createView());
        $repository = $this ->getDoctrine()->getRepository('AppBundle:Category');
        $cates = $repository->findAll();
        $res_array['cates']=$cates;

        $repository = $this ->getDoctrine() ->getRepository('AppBundle:Brand');
        $brands = $repository ->findAll();
        $res_array['brands']=$brands;
        $res_array['title'] = "Login";

        return $this->render('default/login.html.twig', $res_array);
    }
 /**
  * @Route("/logout", name = "logoutpage")
  */
    public function logoutAction(Request $request){
        $session=$request->getSession();
        $session -> clear();
        return $this->redirectToRoute('homepage');
    }
}

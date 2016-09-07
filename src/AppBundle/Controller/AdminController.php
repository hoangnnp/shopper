<?php
/**
 * Created by PhpStorm.
 * User: Hoang
 * Date: 8/18/2016
 * Time: 11:14 AM
 */

namespace AppBundle\Controller;

use AppBundle\Form\BrandType;
use AppBundle\Form\CategoryType;
use AppBundle\Form\CateType;
use AppBundle\Form\EditType;
use AppBundle\Entity\User;
use AppBundle\Entity\Product;
use AppBundle\Form\LoginType;
use AppBundle\Form\CreateProductType;
use AppBundle\Form\ProductImageType;
use AppBundle\Form\UserType;
use Proxies\__CG__\AppBundle\Entity\Brand;
use Proxies\__CG__\AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Gedmo\Translatable\TranslationListener;
use AppBundle\Entity\Image;
use Symfony\Component\Security\Core\Tests\User\UserTest;

class AdminController extends Controller
{
    /**
     * @Route("/admin/", name="adminpage")
     */
    public function adminAction(Request $request)
    {
        $res_array = array();
        $se = $request->getSession();
        if (!$se->has('login')) {
            return $this->render('errorlogin.html.twig');
        }
        return $this->render('admin/Dashboard.html.twig', $res_array);
    }

    /**
     * @Route("admin/product/list", name="productpage")
     */
    public function listproductAction(Request $request)
    {
        $res_array = array();
        $se = $request->getSession();
        if (!$se->has('login')) {
            return $this->render('errorlogin.html.twig');
        }
        $repository = $this->getDoctrine()->getRepository('AppBundle:Product');
        $products = $repository->findAll();
        $res_array['products'] = $products;
        return $this->render('admin/product.html.twig', $res_array);
    }

    /**
     * @Route("admin/product/list/delete/{id}",name="deletepage")
     */
    public function deleteAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $product = $em->getPartialReference('AppBundle\Entity\Product', array('id' => $id));
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute("productpage");
    }

    /**
     * @Route("admin/product/list/edit/{id}",name="editproduct")
     */
    public function editproductAction($id, Request $request)
    {
        $se = $request->getSession();
        $em = $this ->getDoctrine()->getManager();
        $repository = $this ->getDoctrine() ->getRepository('AppBundle:Product');
        $product=$repository->findOneBy(array('id'=>$id));
        $translationRespo = $em->getRepository('Gedmo\Translatable\Entity\Translation');
        $translations = $translationRespo->findTranslations($product);
        $form=$this->createForm(CreateProductType::class);
        $form->get('id')->setData($product->getId());
        $form->get('price')->setData($product->getPrice());
        $form->get('is_feature')->setData($product->getIsFeatured());
        if(isset($translations['vi']['name']))
            $form->get('name_vi')->setData($translations['vi']['name']);
        if(isset($translations['en']['name']))
            $form->get('name_en')->setData($translations['en']['name']);
        if(isset($translations['vi']['state']))
            $form->get('state_vi')->setData($translations['vi']['state']);
        if(isset($translations['en']['state']))
            $form->get('state_en')->setData($translations['en']['state']);
        if(isset($translations['vi']['status']))
            $form->get('status_vi')->setData($translations['vi']['status']);
        if(isset($translations['status_en']))
            $form->get('status_en')->setData($translations['en']['status']);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $create = $form->getData();
            $product->setId($create['id']);
            $product->setPrice($create['price']);
            $product->setIsFeatured($create['is_feature']);
            $translationRespo
                ->translate($product, 'name', 'vi', $create['name_vi'])
                ->translate($product, 'name', 'en', $create['name_en']);
            $translationRespo
                ->translate($product, 'state', 'vi', $create['state_vi'])
                ->translate($product, 'state', 'fr', $create['state_en']);
            $translationRespo
                ->translate($product, 'status', 'vi', $create['status_vi'])
                ->translate($product, 'status', 'fr', $create['status_en']);
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute("productpage");
        }
        $res_array=array('form'=>$form->createView());
        return $this->render('admin/edit.html.twig',$res_array);
    }

    /**
     * @Route("/admin/product/list/{pid}/image/delete/{id}",name="deleteimage")
     */
    public function delimageAction($pid,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $image=$em->getPartialReference('AppBundle\Entity\Image',array('id'=>$id));
        $em->remove($image);
        $em->flush();
        return $this->redirectToRoute('viewimages',array('id'=>$pid));
    }

    /**
     * @Route("/admin/product/list/create",name="createproductpage")
     */
    public function createAction(Request $request)
    {
        $se = $request->getSession();
        if(!$se->has('login'))
        {
            return $this->render('errorlogin.html.twig');
        }
        $form=$this->createForm(CreateProductType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()) {
            $create = $form->getData();
            $product = new Product();
            $product->setPrice($create['price']);
            $product->setCategory($create['category']);
            $product->setBrand($create['brand']);
            $product->setIsFeatured($create['is_feature']);
            $em=$this->getDoctrine()->getManager();
            $repository = $em->getRepository('Gedmo\Translatable\Entity\Translation');
            $repository->translate($product,'state','vi',$create['state_vi'])
                ->translate($product,'state','en',$create['state_en']);
            $repository->translate($product,'status','vi',$create['status_en'])
                ->translate($product,'status','en',$create['status_en']);
            $repository->translate($product, 'name', 'vi', $create['name_vi'])
                ->translate($product, 'name', 'en', $create['name_en']);
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute("productpage");
        }
        $res_array=array('form'=>$form->createView());
        $res_array['url']=$se->get('url');
        $res_array['fullname']=$se->get('fullname');
        $res_array['title']='Create Product';
        return $this->render('admin/createproduct.html.twig',$res_array);
    }

    /**
     * @Route("admin/product/list/{id}/images",name="viewimages")
     */
    public function productImageAction($id, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $product = $em->find('AppBundle:Product',$id);
        $form=$this->createForm(ProductImageType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()) {
            $create = $form->getData();
            $Image = new Image();
            $Image->setUrl($create['url']);
            $Image->setProduct($product);
            $em->persist($Image);
            $em->flush();
        }
        $res_array = array();
        $res_array['pid']=$id;
        $res_array['images'] = $product->getImages();
        $res_array['form'] = $form->createView();
        return $this->render('admin/productImages.html.twig',$res_array);
    }

    /**
     * @Route("/product/category", name="categoriespage")
     */
    public function listcategoryAction(Request $request)
    {
        $res_array = array();
        $se = $request->getSession();
        if (!$se->has('login')) {
            return $this->render('errorlogin.html.twig');
        }
        $repository = $this->getDoctrine()->getRepository('AppBundle:Category');
        $cates = $repository->findAll();
        $res_array['cates'] = $cates;
        return $this->render('admin/catalogory.html.twig', $res_array);
    }

    /**
     * @Route("admin/product/category/delete/{id}",name="deletecatepage")
     */
    public function deletecateAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $cate = $em->getPartialReference('AppBundle\Entity\Category', array('id' => $id));
        $em->remove($cate);
        $em->flush();
        return $this->redirectToRoute("categoriespage");
    }

    /**
     * @Route("admin/product/category/edit/{id}",name="editcategory")
     */
    public function editcategoryAction($id, Request $request)
    {
        $se = $request->getSession();
        $em = $this ->getDoctrine()->getManager();
        $repository = $this ->getDoctrine() ->getRepository('AppBundle:Category');
        $cate=$repository->findOneBy(array('id'=>$id));
        $translationRespo = $em->getRepository('Gedmo\Translatable\Entity\Translation');
        $translations = $translationRespo->findTranslations($cate);
        $form=$this->createForm(CategoryType::class);
        $form->get('id')->setData($cate->getId());
        if(isset($translations['vi']['name']))
            $form->get('name_vi')->setData($translations['vi']['name']);
        if(isset($translations['en']['name']))
            $form->get('name_en')->setData($translations['en']['name']);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $create = $form->getData();
            $cate->setId($create['id']);
            $translationRespo
                ->translate($cate, 'name', 'vi', $create['name_vi'])
                ->translate($cate, 'name', 'en', $create['name_en']);
            $em->persist($cate);
            $em->flush();
            return $this->redirectToRoute("categoriespage");
        }
        $res_array=array('form'=>$form->createView());
        return $this->render('admin/editcate.html.twig',$res_array);
    }
    /**
     * @Route("/admin/product/category/create",name="createcategoriespage")
     */
    public function createcateAction(Request $request)
    {
        $se = $request->getSession();
        if(!$se->has('login'))
        {
            return $this->render('errorlogin.html.twig');
        }
        $form=$this->createForm(CategoryType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()) {
            $create = $form->getData();
            $cate = new Category();
            $em=$this->getDoctrine()->getManager();
            $repository = $em->getRepository('Gedmo\Translatable\Entity\Translation');
            $repository->translate($cate,'name','vi',$create['name_vi'])
                ->translate($cate,'name','en',$create['name_en']);
            $em->persist($cate);
            $em->flush();
            return $this->redirectToRoute("categoriespage");
        }
        $res_array=array('form'=>$form->createView());
        return $this->render('admin/createcate.html.twig',$res_array);
    }
    /**
     * @Route("/product/brand", name="brandpage")
     */
    public function listbrandAction(Request $request)
    {
        $res_array = array();
        $se = $request->getSession();
        if (!$se->has('login')) {
            return $this->render('errorlogin.html.twig');
        }
        $repository = $this->getDoctrine()->getRepository('AppBundle:Brand');
        $brands = $repository->findAll();
        $res_array['brand'] = $brands;
        return $this->render('admin/brand.html.twig', $res_array);
    }
    /**
     * @Route("admin/product/brand/delete/{id}",name="deletebrandpage")
     */
    public function deletebrandAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $cate = $em->getPartialReference('AppBundle\Entity\Brand', array('id' => $id));
        $em->remove($cate);
        $em->flush();
        return $this->redirectToRoute("brandpage");
    }
    /**
     * @Route("admin/product/brand/edit/{id}",name="editbrandpage")
     */
    public function editbrandAction($id, Request $request)
    {
        $se = $request->getSession();
        $em = $this ->getDoctrine()->getManager();
        $repository = $this ->getDoctrine() ->getRepository('AppBundle:Brand');
        $cate=$repository->findOneBy(array('id'=>$id));
        $form=$this->createForm(CategoryType::class);
        $form->get('id')->setData($cate->getId());
        $form->get('name')->setData($cate->getName());
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $create = $form->getData();
            $cate->setId($create['id']);
            $cate->setName($create['name']);
            $em->persist($cate);
            $em->flush();
            return $this->redirectToRoute("categoriespage");
        }
        $res_array=array('form'=>$form->createView());
        return $this->render('admin/editcate.html.twig',$res_array);
    }
    /**
     * @Route("/admin/product/brand/create",name="createbrandpage")
     */
    public function createbrandAction(Request $request)
    {
        $se = $request->getSession();
        if(!$se->has('login'))
        {
            return $this->render('errorlogin.html.twig');
        }
        $form=$this->createForm(BrandType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()) {
            $create = $form->getData();
            $brand = new Brand();
            $brand->setName($create['name']);
            $em=$this->getDoctrine()->getManager();
            $em->persist($brand);
            $em->flush();
            return $this->redirectToRoute("brandpage");
        }
        $res_array=array('form'=>$form->createView());
        return $this->render('admin/createbrand.html.twig',$res_array);
    }
    /**
     * @Route("/customer/list", name="customerlistpage")
     */
    public function listuserAction(Request $request)
    {
        $res_array = array();
        $se = $request->getSession();
        if (!$se->has('login')) {
            return $this->render('errorlogin.html.twig');
        }
        $repository = $this->getDoctrine()->getRepository('AppBundle:User');
        $users = $repository->findAll();
        $res_array['users'] = $users;
        return $this->render('admin/ListCustomer.html.twig', $res_array);
    }
    /**
     * @Route("admin/customer/list/delete/{id}",name="deletecustomerpage")
     */
    public function deletecustomerAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $cate = $em->getPartialReference('AppBundle\Entity\User', array('id' => $id));
        $em->remove($cate);
        $em->flush();
        return $this->redirectToRoute("customerlistpage");
    }
    /**
     * @Route("admin/customer/list/edit/{id}",name="editcustomerpage")
     */
    public function editcustomerAction($id, Request $request)
    {
        $se = $request->getSession();
        $em = $this ->getDoctrine()->getManager();
        $repository = $this ->getDoctrine() ->getRepository('AppBundle:User');
        $cus=$repository->findOneBy(array('id'=>$id));
        $form=$this->createForm(UserType::class);
        $form->get('id')->setData($cus->getId());
        $form->get('username')->setData($cus->getUsername());
        $form->get('password')->setData($cus->getPassword());
        $form->get('fullname')->setData($cus->getFullname());
        $form->get('role')->setData($cus->getRole());
        $form->get('url')->setData($cus->getUrl());
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $create = $form->getData();
            $cus->setId($create['id']);
            $cus->setUsername($create['username']);
            $cus->setPassword($create['password']);
            $cus->setFullname($create['fullname']);
            $cus->setRole($create['role']);
            $cus->setUrl($create['url']);
            $em->persist($cus);
            $em->flush();
            return $this->redirectToRoute("customerlistpage");
        }
        $res_array=array('form'=>$form->createView());
        return $this->render('admin/editcustomer.html.twig',$res_array);
    }
    /**
     * @Route("/admin/customer/list/create",name="createcustomerpage")
     */
    public function createcustomerAction(Request $request)
    {
        $se = $request->getSession();
        if(!$se->has('login'))
        {
            return $this->render('errorlogin.html.twig');
        }
        $form=$this->createForm(UserType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()) {
            $create = $form->getData();
            $user = new User();
            $user -> setUsername($create['username']);
            $user -> setPassword($create['password']);
            $user -> setFullname($create['fullname']);
            $user -> setRole($create['role']);
            $user -> setUrl($create['url']);
            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("customerlistpage");
        }
        $res_array=array('form'=>$form->createView());
        return $this->render('admin/createcustomer.html.twig',$res_array);
    }
}
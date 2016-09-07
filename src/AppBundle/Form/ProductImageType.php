<?php
/**
 * Created by PhpStorm.
 * User: Hoang
 * Date: 8/18/2016
 * Time: 5:13 PM
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class ProductImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('url', urlType::class, array('label' => false, 'attr'=>array('placeholder'=>'Enter your url here','class'=>'form-control')));
    }
}
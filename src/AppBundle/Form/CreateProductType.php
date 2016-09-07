<?php
/**
 * Created by PhpStorm.
 * User: Hoang
 * Date: 8/18/2016
 * Time: 2:14 PM
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CreateProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id',HiddenType::class)
            ->add('name_vi',TextType::class,array('label'=>false))
            ->add('is_feature',CheckboxType::class,array('label'=>false,'required'=>false))
            ->add('name_en',TextType::class,array('label'=>false))
            ->add('price',TextType::class,array('label'=>false))
            ->add('state_vi',TextType::class,array('label'=>false))
            ->add('state_en',TextType::class,array('label' =>false))
            ->add('status_vi',TextType::class,array('label'=>false))
            ->add('status_en',TextType::class,array('label'=>false))
            ->add('category', EntityType::class, array('class' => 'AppBundle\Entity\Category','choice_label' => 'name'))
            ->add('brand', EntityType::class, array('class' => 'AppBundle\Entity\Brand','choice_label' => 'name'));
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Hoang
 * Date: 8/17/2016
 * Time: 6:01 PM
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id',HiddenType::class,array('label'=>false))
            ->add('name',TextType::class,array('label'=>false))
            ->add('subject',TextType::class,array('label'=>false))
            ->add('messages',TextareaType::class,array('label'=>false));
    }
}
<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id',HiddenType::class,array('label'=>false))
            ->add('username',TextType::class,array('label'=>false))
            ->add('password',PasswordType::class,array('label'=>false))
            ->add('role',TextType::class,array('label'=>false))
            ->add('fullname',TextType::class,array('label'=>false))
            ->add('url',TextType::class,array('label'=>false));
    }
}
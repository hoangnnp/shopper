<?php
/**
 * Created by PhpStorm.
 * User: Hoang
 * Date: 8/17/2016
 * Time: 6:01 PM
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class,array('label'=>false))
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message'=>'Your password is not match',
                'error_bubbling'=>true,
                'first_options'  => array('label' => false),
                'second_options' => array('label' => false),
                'first_name'  => 'pass',
                'second_name' => 'repass',
            ))
            ->add('fullname',TextType::class,array('label'=>false));
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Hoang
 * Date: 8/17/2016
 * Time: 5:42 PM
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class,array('label'=>false,'attr' => array(
                'placeholder' => 'Your username',
            )))
            ->add('password',PasswordType::class,array('label'=>false,'attr'=>array('placeholder'=>"Your password")));
    }
}


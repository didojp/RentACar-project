<?php

namespace AppBundle\Form;

use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userName',\Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('firstName', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('lastName', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('password', RepeatedType::class,[
                'type'=>PasswordType::class,
                'invalid_message'=> 'The password fields must match.',
                'options'=>['attr'=>['class'=>'password-field']],
                'required'=>true,
                'first_options'=>['label'=>'Password'],
                'second_options'=>['label'=>'Repeat Password'],
            ])
            ->add('nationality', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('address', \Symfony\Component\Form\Extension\Core\Type\TextType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}

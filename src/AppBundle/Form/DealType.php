<?php

namespace AppBundle\Form;

use AppBundle\Entity\Car;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DealType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('car', EntityType::class,[
                'class'=>'AppBundle\Entity\Car',
                'choice_label'=>'id',
            ])
            ->add('carPrice'

            )
            ->add('user', EntityType::class,[
                'class'=>'AppBundle\Entity\User',
                'choice_label'=>'username',
            ])
            ->add('fromDate', DateTimeType::class)
            ->add('toDate', DateTimeType::class)
            ->add('numberOfDays')
            ->add('dealPrice', MoneyType::class)
           ;

    }// това ли ползвам или Collection type, за да вмъкна обект кола?

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Deal'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_deal';
    }


}

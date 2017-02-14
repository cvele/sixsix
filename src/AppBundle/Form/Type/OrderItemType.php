<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Meal;
use AppBundle\Entity\OrderItem;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('meal', EntityType::class, [
                'class'        => Meal::class,
                'choice_label' => 'displayName',
                'multiple'     => true,
                'expanded'     => true
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderItem::class,
            'attr' => [
                'class' => 'form-vertical'
            ]
        ]);
    }
}

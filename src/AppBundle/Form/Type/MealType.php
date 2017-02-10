<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Meal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Tbbc\MoneyBundle\Form\Type\SimpleMoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class MealType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('displayName')
            ->add('description')
            ->add('position', NumberType::class)
            ->add('price', SimpleMoneyType::class)
            ->add('category', EntityType::class, [
                'class'        => 'AppBundle:Category',
                'choice_label' => 'displayName',
            ])
            ->add('inStock', CheckboxType::class, [
                    'required' => false,
            ])
            ->add('options', CollectionType::class, array(
                'entry_type'    => MealOptionType::class,
                'allow_add'     => true,
                'by_reference'  => false,
                'allow_delete'  => true,
                'entry_options' => [
                    'label' => false
                ]
            ))
            ->add('save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Meal::class,
        ));
    }
}

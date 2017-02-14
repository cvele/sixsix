<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Meal;
use AppBundle\Entity\Order;
use AppBundle\Entity\MealOption;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class MealOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orderItems', OrderItemType::class)
        ;
        //
        // $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
        //     $order = $event->getData();
        //     $form = $event->getForm();
        //
        //     $orderItems = $form->get('orderItems')->all();
        //     foreach($orderItems as $orderItem) {
        //         $orderItem->add('options', EntityType::class, [
        //             'class' => MealOption::class,
        //             'choice_label' => 'displayName',
        //             'compound' => true
        //         ]);
        //     }
        // });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Order::class,
        ));
    }
}

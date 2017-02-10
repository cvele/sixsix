<?php

namespace AppBundle\Controller;

use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use AppBundle\Form\Type\MealType;
use AppBundle\Entity\Meal;

class AdminController extends BaseAdminController
{
    // ...

    protected function createNewMealEntity()
    {
        $meal = new Meal('RSD');
        return $meal;
    }

    // protected function createMealNewForm($entity, array $entityProperties)
    // {
    //     return $this->createForm(MealType::class, $entity);
    // }
    //
    // protected function createEditForm($entity, array $entityProperties)
    // {
    //     return $this->createMealNewForm($entity, $entityProperties);
    // }

}

<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Order;
use AppBundle\Form\Type\MealOrderType;
use JavierEguiluz\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;
use AppBundle\Entity\Meal;
use AppBundle\Entity\OrderItem;
use AppBundle\Entity\OrderItemOption;
use Money\Money;

class AdminController extends BaseAdminController
{
    // ...

    protected function createNewMealEntity()
    {
        $meal = new Meal('RSD');
        return $meal;
    }

    public function createNewUserEntity()
    {
       return $this->get('fos_user.user_manager')->createUser();
    }

   public function prePersistUserEntity($user)
   {
       $this->get('fos_user.user_manager')->updateUser($user, false);
   }

    protected function createOrderNewForm($entity, array $entityProperties)
    {
        return $this->createForm(MealOrderType::class, $entity);
    }

    protected function createNewOrderEntity()
    {
        $meal = new Meal('RSD');
        return $meal;
    }

    protected function newOrderAction()
    {
        $categories = $this->getDoctrine()
                            ->getRepository('AppBundle:Category')
                            ->findAll([], ['position' => 'DESC']);

        if ($this->request->getMethod() == 'POST') {

            $totalPrice = Money::RSD(0);
            $order = new Order();
            $order->setFirstname($this->request->request->get('firstname'));
            $order->setLastname($this->request->request->get('lastname'));
            $order->setAddress($this->request->request->get('address'));
            $order->setAreaCode($this->request->request->get('area_code'));
            $order->setPhone($this->request->request->get('phone'));
            $order->setEmail($this->request->request->get('email'));
            $order->setTax($this->container->getParameter('tax'));
            $order->setPrice($totalPrice);

            $meals = $this->request->request->get('meals');
            foreach($meals as $mealId => $options) {

                $meal = $this->getDoctrine()->getRepository('AppBundle:Meal')->find($mealId);
                $orderItem = new OrderItem;
                $orderItem->setOrder($order);
                $orderItem->setMeal($meal);
                $totalPrice = $totalPrice->add($meal->getPrice());

                foreach($options['options'] as $optionId => $option) {
                    $mealOption = $this->getDoctrine()->getRepository('AppBundle:MealOption')->find($optionId);
                    $orderItemOption = new OrderItemOption;
                    $orderItemOption->setOrderItem($orderItem);
                    $orderItemOption->setMealOption($mealOption);
                    $orderItem->addOrderItemOption($orderItemOption);
                    $totalPrice = $totalPrice->add($mealOption->getPrice());
                }

                $order->addOrderItem($orderItem);
            }


            $order->setPrice($totalPrice);
            $this->em->persist($order);
            $this->em->flush();

            return $this->redirect($this->generateUrl('easyadmin', array('action' => 'list', 'entity' => 'Order')));
        }

        // replace this example code with whatever you need
        return $this->render('admin/Order/new.html.twig', [
            'categories' => $categories,
        ]);
    }

    //
    // protected function createEditForm($entity, array $entityProperties)
    // {
    //     return $this->createMealNewForm($entity, $entityProperties);
    // }

}

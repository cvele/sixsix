<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Traits\PriceTrait;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\IpTraceable\Traits\IpTraceableEntity;

/**
 * OrderItemOption
 *
 * @ORM\Table(name="order_item_option")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderItemOptionRepository")
 */
class OrderItemOption
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var OrderItem
     * @ORM\ManyToOne(targetEntity="OrderItem")
     * @ORM\JoinColumn(name="order_item_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $orderItem;

    /**
     * @var MealOption
     * @ORM\ManyToOne(targetEntity="MealOption")
     * @ORM\JoinColumn(name="meal_option_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $mealOption;

    /**
     * Serializes MealOption Entity related to this order,
     * in case that meal option is updated or deleted in the future
     * @var string
     *
     * @ORM\Column(name="serialized_item", type="text")
     */
    private $serializedItem;

    /**
     * Add price field to this entity.
     * Money\Money object returned.
     */
    use PriceTrait {
        PriceTrait::__construct as private priceTraitConstructor;
    }

    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /**
     * Hook ip-traceable behavior
     * updates createdFromIp, updatedFromIp fields
     */
    use IpTraceableEntity;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of Order Item
     *
     * @return Meal
     */
    public function getOrderItem()
    {
        return $this->orderItem;
    }

    /**
     * Set the value of Order Item
     *
     * @param OrderItem $orderItem
     *
     * @return self
     */
    public function setOrderItem(OrderItem $orderItem)
    {
        $this->orderItem = $orderItem;

        return $this;
    }


    /**
     * Get the value of Meal Option
     *
     * @return MealOption
     */
    public function getMealOption()
    {
        return $this->mealOption;
    }

    /**
     * Set the value of Meal Option
     *
     * @param MealOption $mealOption
     *
     * @return self
     */
    public function setMealOption(MealOption $mealOption)
    {
        $this->mealOption = $mealOption;

        return $this;
    }

    /**
     * Get the value of Serialized Item
     *
     * @return string
     */
    public function getSerializedItem()
    {
        return $this->serializedItem;
    }

    /**
     * Set the value of Serialized Item
     *
     * @param string $serializedItem
     *
     * @return self
     */
    public function setSerializedItem($serializedItem)
    {
        $this->serializedItem = $serializedItem;

        return $this;
    }

}

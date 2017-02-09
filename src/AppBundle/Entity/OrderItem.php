<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Traits\PriceTrait;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\IpTraceable\Traits\IpTraceableEntity;

/**
 *
 * OrderItem
 *
 * @ORM\Table(name="order_items")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderItemRepository")
 */
class OrderItem
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
     * @var Order
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="orderItems")
     * @ORM\JoinColumn(name="order_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $order;

    /**
     * @var Meal
     * @ORM\ManyToOne(targetEntity="Meal")
     * @ORM\JoinColumn(name="meal_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $meal;

    /**
     * Add price field to this entity.
     * Money\Money object returned.
     */
    use PriceTrait {
        PriceTrait::__construct as private priceTraitConstructor;
    }

    /**
     * Serializes Meal Entity related to this order,
     * in case that meal is updated or deleted in the future
     * @var string
     *
     * @ORM\Column(name="serialized_item", type="text")
     */
    private $serializedItem;

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
     * Constructor
     * @param string $currency
     */
    public function __construct($currency = 'RSD')
    {
        $this->priceTraitConstructor($currency);
    }

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
     * Get the value of Meal
     *
     * @return Meal
     */
    public function getMeal()
    {
        return $this->meal;
    }

    /**
     * Set the value of Meal
     *
     * @param Meal $meal
     *
     * @return self
     */
    public function setMeal(Meal $meal)
    {
        $this->meal = $meal;

        return $this;
    }


    /**
     * Get the value of Order
     *
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set the value of Order
     *
     * @param Order $order
     *
     * @return self
     */
    public function setOrder(Order $order)
    {
        $this->order = $order;

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

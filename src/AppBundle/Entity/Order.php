<?php

namespace AppBundle\Entity;

use AppBundle\Entity\Traits\ContactTrait;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Traits\PriceTrait;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\IpTraceable\Traits\IpTraceableEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Orders
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrderRepository")
 */
class Order
{
    /**
     * @var int
     */
    const STATUS_CANCELED = 'Canceled';

    /**
     * @var int
     */
    const STATUS_PENDING = 'Pending';

    /**
     * @var int
     */
    const STATUS_ACCEPTED = 'Accepted';

    /**
     * @var int
     */
    const STATUS_COMPLETED = 'Completed';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="OrderItem", mappedBy="order")
     */
    private $orderItems;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * Add price field to this entity.
     * Money\Money object returned.
     */
    use PriceTrait {
        PriceTrait::__construct as private priceTraitConstructor;
    }

    /** adds contact fields **/
    use ContactTrait;

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
        $this->orderItems = new ArrayCollection;
    }

    /**
     * Returns order status list
     * @return array
     */
    public static function getStatusList(): array
    {
        return [
                self::STATUS_CANCELED  => 0,
                self::STATUS_PENDING   => 1,
                self::STATUS_ACCEPTED  => 2,
                self::STATUS_COMPLETED => 3
                ];
    }

    /**
     * Return status code by status
     * @param  string $status
     * @return int
     */
    private function getStatusCode($status): int
    {
        $statusList = $this->getStatusList();
        if (!isset($statusList[$status])) {
            throw new \Exception(sprintf("Status `%s` is not one of allowed statuses", $status));
        }
        return $statusList[$status];
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set $status
     *
     * @param int $status
     *
     * @return Order
     */
    public function setStatus($status): self
    {
        $this->status = $this->getStatusCode($status);

        return $this;
    }

    /**
     * Get status name
     *
     * @return string
     */
    public function getStatusName(): string
    {
        $statusList = array_flip($this->getStatusList());
        return $statusList[$this->status];
    }

    /**
     * Get status code
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }


    /**
     * Get the value of Order Items
     *
     * @return ArrayCollection
     */
    public function getOrderItems()
    {
        return $this->orderItems;
    }


    /**
     * Adds meal addon for this meal
     *
     * @param  OrderItem $item
     * @return Meal
     */
    public function addOrderItem(OrderItem $item): self
    {
        $this->orderItems->add($item);

        return $this;
    }

    /**
     * Removes meal addon for this meal
     *
     * @param  OrderItem $item
     * @return Meal
     */
    public function removeOrderItem(OrderItem $item): self
    {
        $this->orderItems->removeElement($item);

        return $this;
    }

}

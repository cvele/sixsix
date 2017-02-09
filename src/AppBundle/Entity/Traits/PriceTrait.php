<?php

namespace AppBundle\Entity\Traits;

use Money\Money;
use Doctrine\ORM\Mapping as ORM;

/**
 * Trait adds price field to entities
 */
trait PriceTrait
{
    /**
     * @var Money
     *
     * @ORM\Embedded(class="Money\Money")
     */
    private $price;

    /**
     * constructor
     * @param string $currency
     */
    public function __construct($currency = 'RSD')
    {
        $this->price = new Money\Money(0, new Money\Currency($currency));
    }

    /**
     * @param Money $price
     * @return self
     */
    public function setPrice(Money $price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return Money
     */
    public function getPrice(): Money
    {
        return $this->price;
    }
}

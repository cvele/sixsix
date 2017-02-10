<?php

namespace AppBundle\Entity\Traits;

use Money\Money;
use Money\Currency;
use Doctrine\ORM\Mapping as ORM;
use Tbbc\MoneyBundle\Formatter\MoneyFormatter;

/**
 * Trait adds price field to entities
 */
trait PriceTrait
{
    /**
     * @var int
     *
     * @ORM\Column(name="price_amount", type="integer")
     */
    private $priceAmount;

    /**
     * @var string
     *
     * @ORM\Column(name="price_currency", type="string", length=64)
     */
    private $priceCurrency;

    /**
     * constructor
     * @param string $currency
     */
    public function __construct($currency = 'RSD')
    {
        $this->price = new Money(0, new Currency($currency));
    }

    /**
     * get Money
     *
     * @return Money
     */
    public function getPrice(): ?Money
    {
        if (!$this->priceCurrency) {
            return null;
        }
        if (!$this->priceAmount) {
            return new Money(0, new Currency($this->priceCurrency));
        }
        return new Money($this->priceAmount, new Currency($this->priceCurrency));
    }

    /**
     * Set price
     *
     * @param Money $price
     * @return Money
     */
    public function setPrice(Money $price): self
    {
        $this->priceAmount = $price->getAmount();
        $this->priceCurrency = $price->getCurrency()->getCode();

        return $this;
    }

    /**
     * Get the value of Price Amount
     *
     * @return int
     */
    public function getPriceAmount()
    {
        return $this->priceAmount;
    }

    /**
     * Get the value of Price Currency
     *
     * @return string
     */
    public function getPriceCurrency()
    {
        return $this->priceCurrency;
    }

    public function getPriceAsText()
    {
        $formatter = new MoneyFormatter();
        return $formatter->formatMoney($this->getPrice());
    }

}

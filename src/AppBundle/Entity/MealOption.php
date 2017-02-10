<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use AppBundle\Entity\Traits\NameTrait;
use AppBundle\Entity\Traits\PriceTrait;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\IpTraceable\Traits\IpTraceableEntity;
use Gedmo\Blameable\Traits\BlameableEntity;

/**
 * MealOption
 *
 * @ORM\Table(name="meal_option")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MealOptionRepository")
 */
class MealOption
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
     * @var Meal
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="Meal", inversedBy="options")
     * @ORM\JoinColumn(name="meal_id", referencedColumnName="id", onDelete="CASCADE")
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
     * Adds name and displayName props
     * and getters/setters
     */
    use NameTrait;

    /**
     * @var int
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

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
     * Hook blameable behavior
     * updates createdBy, updatedBy fields
     */
    use BlameableEntity;


    /**
     * constructor
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
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the value of Position
     *
     * @return mixed
     */
    public function getPosition(): ?int
    {
        return $this->position;
    }

    /**
     * Set the value of Position
     *
     * @param int $position
     *
     * @return self
     */
    public function setPosition($position): self
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get the value of Meal
     *
     * @return Meal
     */
    public function getMeal(): ?Meal
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

    public function __toString()
    {
        return $this->getDisplayName() . " " . $this->getPriceAsText();
    }

}

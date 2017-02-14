<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use AppBundle\Entity\Traits\NameTrait;
use Gedmo\Blameable\Traits\BlameableEntity;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CategoryRepository")
 */
class Category
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
     * Adds name and displayName props
     * and getters/setters
     */
    use NameTrait;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Meal", mappedBy="category")
     */
    private $meals;

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
     * Hook blameable behavior
     * updates createdBy, updatedBy fields
     */
    use BlameableEntity;

    /**
     * constructor
     */
    public function __construct()
    {
       $this->meals = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of Meals
     *
     * @return ArrayCollection
     */
    public function getMeals()
    {
        return $this->meals;
    }

    /**
     * Returns string representation
     * @return string
     */
    public function __toString(): string
    {
        return $this->getDisplayName();
    }


    /**
     * Get the value of Position
     *
     * @return int
     */
    public function getPosition()
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
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return int
     */
    public function getMealCount()
    {
        return $this->meals->count();
    }

}

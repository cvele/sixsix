<?php

namespace AppBundle\Entity;

use ArrayObject;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Traits\PriceTrait;
use AppBundle\Entity\Traits\NameTrait;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Gedmo\Blameable\Traits\BlameableEntity;

/**
 * Meal
 *
 * @ORM\Table(name="meals")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MealRepository")
 * @Vich\Uploadable
 */
class Meal
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
     * @var Category
     * @Gedmo\SortableGroup
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="meals")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $category;

    /**
     * @var bool
     *
     * @ORM\Column(name="in_stock", type="boolean")
     */
    private $inStock = true;

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
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var int
     * @Gedmo\SortablePosition
     * @ORM\Column(name="position", type="integer")
     */
    private $position = 0;

    /**
     * @var MealOption
     * @ORM\OneToMany(targetEntity="MealOption", mappedBy="meal", cascade={"persist"})
     */
    private $options;

    /**
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * Hook blameable behavior
     * updates createdBy, updatedBy fields
     */
    use BlameableEntity;

    /**
     * Constructor
     * @param string $currency
     */
    public function __construct($currency = 'RSD')
    {
        $this->priceTraitConstructor($currency);
        $this->options = new ArrayCollection();
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
     * Set inStock
     *
     * @param bool $inStock
     *
     * @return Meal
     */
    public function setInStock($inStock): self
    {
        $this->inStock = $inStock;

        return $this;
    }

    /**
     * Get inStock
     *
     * @return bool
     */
    public function getInStock(): bool
    {
        return $this->inStock;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Meal
     */
    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Get the value of Category
     *
     * @return Category
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * Set the value of Category
     *
     * @param Category $category
     *
     * @return self
     */
    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get the value of Position
     *
     * @return int
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
     * @return ArrayObject
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Adds meal option for this meal
     *
     * @param  MealOption $option
     * @return Meal
     */
    public function addOption(MealOption $option): self
    {
        $option->setMeal($this);
        $this->options->add($option);

        return $this;
    }

    /**
     * Removes meal option for this meal
     *
     * @param  MealOption $option
     * @return Meal
     */
    public function removeOption(MealOption $option): self
    {
        $this->options->removeElement($option);

        return $this;
    }

    public function __toString()
    {
        return $this->getDisplayName();
    }

    public function getOptionCount()
    {
        return $this->getOptions()->count();
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->updatedAt = new \DateTime('now');
        }
    }

    /**
     * @return string
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }
}

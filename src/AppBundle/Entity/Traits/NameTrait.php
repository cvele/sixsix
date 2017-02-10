<?php

namespace AppBundle\Entity\Traits;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

trait NameTrait
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="display_name", type="string", length=255, nullable=true)
     */
    private $displayName;

    /**
     * @var string
     * @Gedmo\Slug(handlers={
     *      @Gedmo\SlugHandler(class="Gedmo\Sluggable\Handler\InversedRelativeSlugHandler", options={
     *          @Gedmo\SlugHandlerOption(name="relationClass", value="Sluggable\Fixture\Handler\User"),
     *          @Gedmo\SlugHandlerOption(name="mappedBy", value="company"),
     *          @Gedmo\SlugHandlerOption(name="inverseSlugField", value="slug")
     *      })
     * }, fields={"name"})
     * @ORM\Column(length=64, unique=true)
     */
    private $slug;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set displayName
     *
     * @param string $displayName
     *
     * @return self
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;

        return $this;
    }

    /**
     * Get displayName
     *
     * @return string
     */
    public function getDisplayName(): ?string
    {
        if (!$this->displayName) {
            return $this->getName();
        }

        return $this->displayName;
    }

    /**
     * Get the value of Slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

}

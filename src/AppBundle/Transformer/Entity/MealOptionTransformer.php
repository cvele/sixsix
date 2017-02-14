<?php
namespace AppBundle\Transformer\Entity;

use AppBundle\Entity\MealOption;
use League\Fractal;

/**
 * Transforms MealOption entity into seralizable array
 */
class MealOptionTransformer extends Fractal\TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'meal'
    ];

    /**
     * @inheritDoc
     *
     * @param  MealOption   $meal
     * @return array
     */
	public function transform(MealOption $option)
	{
	    return [
	        'id'          => (int) $option->getId(),
	        'name'        => $option->getName(),
	        'displayName' => $option->getDisplayName(),
	        'slug'        => $option->getSlug(),
            'price'       => sprintf("%s %s", $option->getPrice()->getAmount(), $option->getPrice()->getCurrency()),
            'createdAt'   => $option->getCreatedAt(),
            'updatedAt'   => $option->getUpdatedAt()
	    ];
	}

    /**
     * Include Meal
     *
     * @param MealOption $option
     * @return \League\Fractal\Resource\Item
     */
    public function includeMeal(MealOption $option)
    {
        $meal = $option->getMeal();

        return $this->item($meal, new MealTransformer);
    }
}

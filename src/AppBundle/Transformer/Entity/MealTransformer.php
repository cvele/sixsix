<?php
namespace AppBundle\Transformer\Entity;

use AppBundle\Entity\Meal;
use League\Fractal;

/**
 * Transforms Meal entity into seralizable array
 */
class MealTransformer extends Fractal\TransformerAbstract
{
    /**
     * @inheritDoc
     *
     * @param  Meal   $meal
     * @return array
     */
	public function transform(Meal $meal)
	{
	    return [
	        'id'          => (int) $meal->getId(),
	        'name'        => $meal->getName(),
	        'displayName' => $meal->getDisplayName(),
	        'slug'        => $meal->getSlug(),
            'category'    => $meal->getCategory()->__toString(),
            'price'       => sprintf("%s %s", $meal->getPrice()->getAmount(), $meal->getPrice()->getCurrency()),
            'createdAt'   => $meal->getCreatedAt(),
            'updatedAt'   => $meal->getUpdatedAt()
	    ];
	}
}

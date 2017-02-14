<?php

namespace AppBundle\Event\Listener;

use AppBundle\Entity\OrderItem;
use AppBundle\Entity\OrderItemOption;
use Doctrine\ORM\Event\LifecycleEventArgs;
use League\Fractal\TransformerAbstract;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;

/**
 * Seralizes items for orders to maintain history
 * when meals or options are deleted
 */
class SerializeListener
{
    /**
     * @var Manager
     */
    protected $serializeManager;

    /**
     * @var TransformerAbstract
     */
    protected $mealTransformer;

    /**
     * @var TransformerAbstract
     */
    protected $mealOptionTransfomer;



    /**
     * @param Manager             $serializeManager
     * @param TransformerAbstract $mealTransformer
     * @param TransformerAbstract $mealOptionTransfomer
     */
    public function __construct(Manager $serializeManager,TransformerAbstract $mealTransformer, TransformerAbstract $mealOptionTransfomer)
    {
        $this->mealOptionTransfomer = $mealOptionTransfomer;
        $this->mealTransformer      = $mealTransformer;
        $this->serializeManager     = $serializeManager;
    }

    /**
     * @inheritDoc
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $entity = $eventArgs->getEntity();
        $entityManager = $eventArgs->getEntityManager();

        if ($entity instanceof OrderItem) {
            $this->serializeMealForOrderItem($entity);
        }

        if ($entity instanceof OrderItemOption) {
            $this->serializeMealOptionForOrderItemOption($entity);
        }
    }

    private function serializeMealForOrderItem(OrderItem $entity)
    {
        $resource = new Item($entity->getMeal(), $this->mealTransformer, 'meal');
        $serializedItem = $this->serializeManager->createData($resource)->toJson();
        $entity->setSerializedItem($serializedItem);
    }

    private function serializeMealOptionForOrderItemOption(OrderItemOption $entity)
    {
        $resource = new Item($entity->getMealOption(), $this->mealOptionTransfomer, 'mealOption');
        $serializedItem = $this->serializeManager->createData($resource)->toJson();
        $entity->setSerializedItem($serializedItem);
    }
}

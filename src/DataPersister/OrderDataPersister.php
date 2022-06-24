<?php

declare(strict_types=1);

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Contract\DataPersister\OrderDataPersisterInterface;
use App\Contract\DataProvider\OrderStatusDataProviderInterface;
use App\Entity\Order;
use App\Entity\OrderStatus;

final class OrderDataPersister extends AbstractDataPersister implements OrderDataPersisterInterface
{
    private OrderStatusDataProviderInterface $orderStatusDataProvider;

    public function __construct(
        ContextAwareDataPersisterInterface $decorated,
        OrderStatusDataProviderInterface $orderStatusDataProvider
    ) {
        parent::__construct($decorated);

        $this->orderStatusDataProvider = $orderStatusDataProvider;
    }

    public function persist($data, array $context = [])
    {
        if (
            $data instanceof Order && ($context['collection_operation_name'] ?? null) === 'post'
        ) {
            $data->status = $this->orderStatusDataProvider->getOneOrNull(OrderStatus::CREATED);
        }

        return parent::persist($data, $context);
    }
}
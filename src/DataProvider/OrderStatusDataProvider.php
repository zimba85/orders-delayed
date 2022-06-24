<?php

declare(strict_types=1);

namespace App\DataProvider;

use App\Contract\DataProvider\OrderStatusDataProviderInterface;
use App\Entity\OrderStatus;

final class OrderStatusDataProvider extends AbstractDataProvider implements OrderStatusDataProviderInterface
{
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return OrderStatus::class === $resourceClass;
    }

    public function getOneOrNull($id): ?OrderStatus
    {
        return $this->getItem(OrderStatus::class, $id);
    }
}

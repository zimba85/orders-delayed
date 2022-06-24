<?php

declare(strict_types=1);

namespace App\DataProvider;

use App\Contract\DataProvider\OrderDataProviderInterface;
use App\Entity\Order;
use App\Entity\OrderStatus;
use DateTime;

final class OrderDataProvider extends AbstractDataProvider implements OrderDataProviderInterface
{
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Order::class === $resourceClass;
    }

    public function getDelayedOrders(DateTime $time): iterable
    {
        $manager = $this->managerRegistry->getManagerForClass(Order::class);
        $repository = $manager->getRepository(Order::class);
        $queryBuilder = $repository->createQueryBuilder('orders')
            ->andWhere('orders.estimatedArrival < :time')
            ->andWhere('orders.status != :delivered')
            ->setParameter('time', $time)
            ->setParameter('delivered', OrderStatus::DELIVERED);

        return $queryBuilder->getQuery()->getResult();
    }
}

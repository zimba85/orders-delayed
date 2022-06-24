<?php

declare(strict_types=1);

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use Doctrine\Persistence\ManagerRegistry;

abstract class AbstractDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    protected ManagerRegistry $managerRegistry;
    protected iterable $itemExtensions;

    public function __construct(ManagerRegistry $managerRegistry, iterable $itemExtensions)
    {
        $this->managerRegistry = $managerRegistry;
        $this->itemExtensions = $itemExtensions;
    }

    abstract public function supports(string $resourceClass, string $operationName = null, array $context = []): bool;

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = []): ?object
    {
        $manager = $this->managerRegistry->getManagerForClass($resourceClass);
        $repository = $manager->getRepository($resourceClass);
        $queryBuilder = $repository->createQueryBuilder('table')
            ->where('table.id = :id')
            ->setParameter('id', $id);

        return $queryBuilder->getQuery()->getOneOrNullResult();
    }
}

<?php

declare(strict_types=1);

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

abstract class AbstractDataPersister implements ContextAwareDataPersisterInterface
{
    protected ContextAwareDataPersisterInterface $decorated;

    public function __construct(ContextAwareDataPersisterInterface $decorated)
    {
        $this->decorated = $decorated;
    }

    public function supports($data, array $context = []): bool
    {
        return $this->decorated->supports($data, $context);
    }

    public function persist($data, array $context = [])
    {
        return $this->decorated->persist($data, $context);
    }

    public function remove($data, array $context = [])
    {
        return $this->decorated->remove($data, $context);
    }
}
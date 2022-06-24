<?php

declare(strict_types=1);

namespace App\Contract\DataPersister;

interface OrderDelayedDataPersisterInterface
{
    public function persist($data, array $context = []);
}

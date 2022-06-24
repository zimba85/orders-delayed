<?php

declare(strict_types=1);

namespace App\Contract\DataProvider;

use App\Entity\OrderStatus;

interface OrderStatusDataProviderInterface
{
    public function getOneOrNull($id): ?OrderStatus;
}

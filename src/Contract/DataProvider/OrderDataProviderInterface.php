<?php

declare(strict_types=1);

namespace App\Contract\DataProvider;

use DateTime;

interface OrderDataProviderInterface
{
    public function getDelayedOrders(DateTime $time): iterable;
}

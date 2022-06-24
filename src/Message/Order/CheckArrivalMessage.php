<?php

declare(strict_types=1);

namespace App\Message\Order;

use App\Contract\Message\SyncMessageInterface;
use DateTime;

class CheckArrivalMessage implements SyncMessageInterface
{
    private DateTime $time;

    public function __construct(DateTime $time)
    {
        $this->time = $time;
    }

    public function getTime(): DateTime
    {
        return $this->time;
    }
}

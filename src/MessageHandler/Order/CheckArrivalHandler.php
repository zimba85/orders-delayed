<?php

declare(strict_types=1);

namespace App\MessageHandler\Order;

use App\Contract\DataPersister\OrderDelayedDataPersisterInterface;
use App\Contract\DataProvider\OrderDataProviderInterface;
use App\Entity\OrderDelayed;
use App\Message\Order\CheckArrivalMessage;
use DateInterval;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;

class CheckArrivalHandler implements MessageSubscriberInterface
{
    private OrderDataProviderInterface $orderDataProvider;

    private OrderDelayedDataPersisterInterface $orderDelayedDataPersister;

    public function __construct(
        OrderDataProviderInterface $orderDataProvider,
        OrderDelayedDataPersisterInterface $orderDelayedDataPersister
    ) {
        $this->orderDataProvider = $orderDataProvider;
        $this->orderDelayedDataPersister = $orderDelayedDataPersister;
    }

    public function __invoke(CheckArrivalMessage $message)
    {
        $time = $message->getTime();

        foreach ($this->orderDataProvider->getDelayedOrders($time) as $order) {
            $delayedOrder = new OrderDelayed();
            $delayedOrder->order = $order;
            $delayedOrder->checkTime = $time;
            $delayedOrder->estimatedArrival = $time->add(new DateInterval('P2D'));

            $this->orderDelayedDataPersister->persist($delayedOrder);
        }
    }

    public static function getHandledMessages(): iterable
    {
        yield CheckArrivalMessage::class;
    }
}

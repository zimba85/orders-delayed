<?php

declare(strict_types=1);

namespace App\Command\Order;

use App\Message\Order\CheckArrivalMessage;
use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CheckArrivalCommand extends Command
{
    protected static $defaultName = 'app:order:check-arrival';

    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->bus->dispatch(new CheckArrivalMessage(new DateTime('now')));

        return Command::SUCCESS;
    }
}

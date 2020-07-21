<?php
declare(strict_types=1);

namespace Application\Console;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class EchoCommand
 *
 * @package Application\Console
 */
class EchoCommand extends Command
{
    /**
     * Configures the command
     */
    protected function configure(): void
    {
        $this
            ->setName('app:echo')
            ->setDescription('Тестовый вывод в консоль');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Тестовое сообщение');

        return 0;
    }
}
<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\FormatterHelper;

class PrintCommand extends Command
{
    protected static $defaultName = 'print';

    protected function configure()
    {
        $this->setDescription('Display board-wise tasks and notes');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $textStyle = new OutputFormatterStyle('cyan', 'default');
        $output->getFormatter()->setStyle('text', $textStyle);
        $format = new FormatterHelper();
        $output->writeln($format->formatBlock(["Type `hourglass` to get started! \xE2\x8C\x9B"], 'text', TRUE));
    }
}
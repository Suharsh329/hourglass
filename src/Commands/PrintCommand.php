<?php

namespace App\Commands;

use App\Helpers\Display;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\FormatterHelper;

class PrintCommand extends Command
{
    protected static $defaultName = '_print';

    protected $display;

    protected $checkBoxEmpty = "\xE2\x98\x90  ";
    protected $checked = "\xE2\x9C\x93  ";
    protected $note = "\xE2\x97\x88  ";

    public function __construct(Display $display)
    {
        $this->display = $display;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Displays board-wise tasks and notes');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $textStyle = new OutputFormatterStyle('cyan', 'default');
        $output->getFormatter()->setStyle('text', $textStyle);
        $format = new FormatterHelper();

        $errorStyle = new OutputFormatterStyle('red', 'default');
        $output->getFormatter()->setStyle('error', $errorStyle);

        $warningStyle = new OutputFormatterStyle('yellow', 'default');
        $output->getFormatter()->setStyle('warning', $warningStyle);

        if (!$this->display->hasEntries()) {
            $output->writeln($format->formatBlock(["Type `hourglass list` to get started! \xE2\x8C\x9B"], 'text', TRUE));
            return;
        }

        $entries = $this->display->getEntries();

        $board = '';

        foreach ($entries as $entry) {
            if ($board !== $entry['board']) {
                $board = $entry['board'];
                $output->writeln('');
                $output->writeln("\e[4m$board\e[0m");
            }

            $output->write("  " . $entry['id']);
            $output->write(' ');

            if ($entry['type'] == 'task') {
                if ($entry['completed']) {
                    $output->writeln("<info>$this->checked</info>" . "<text>\e[9m" . $entry['description'] . "\e[29m</text>");
                } else {
                    if ($entry['due'] !== 'Indefinite') {
                        if ($entry['due'] < 0) {
                            $due = "<error>(OVERDUE)</error>";
                        } else if ($entry['due'] == 0) {
                            $due = "<error>(Due today!!)</error>";
                        } else if ($entry['due'] == 1) {
                            $due = "<error>(Due tomorrow!)</error>";
                        } else {
                            if ($entry['due'] <= 3) {
                                $due = "<error>(Due in " . $entry['due'] . " days)</error>";
                            } else if ($entry['due'] <= 7) {
                                $due = "<warning>(Due in " . $entry['due'] . " days)</warning>";
                            } else {
                                $due = "<info>(Due in " . $entry['due'] . " days)</info>";
                            }
                        }
                        $output->writeln($this->checkBoxEmpty . "<text>" . $entry['description'] . "</text> " . $due);
                    } else {
                        $output->writeln($this->checkBoxEmpty . "<text>" . $entry['description'] . "</text>");
                    }
                }
            } else {
                $output->writeln($this->note . "<text>" . $entry['description'] . "</text>");
            }
        }
        $output->writeln('');
    }
}

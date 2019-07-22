<?php

namespace App\Commands;


use App\Helpers\Filter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\FormatterHelper;

class FilterCommand extends Command
{

    protected static $defaultName = 'filter';
    private $filter;

    protected $checkBoxEmpty = "\xE2\x98\x90  ";
    protected $checked = "\xE2\x9C\x93  ";
    protected $note = "\xE2\x97\x88  ";

    public function __construct(Filter $filter)
    {
        $this->filter = $filter;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Filters entries')
            ->addArgument('filter', InputArgument::REQUIRED, 'Type of filter')
            ->addArgument('value', InputArgument::OPTIONAL, 'Specify value')
            ->addOption(
                'board',
                'b',
                InputOption::VALUE_OPTIONAL,
                'Specify which board the task belongs to. A new board will be created if it does not exist.'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $view = [];

        $filter = $input->getArgument('filter');

        $value = '';

        if ($input->getArgument('value')) {
            $value = $input->getArgument('value');
        }

        $board = '';

        if ($input->getOption('board')) {
            $board = $input->getOption('board');
        }

        switch ($filter) {
            case 'a':
                $view = $this->filter->alpha($board);
                break;
            case 'd':
                $view = $this->filter->dueDate($value, $board);
                break;
            case 'n':
                $view = $this->filter->notes($board);
                break;
            case 't':
                $view = $this->filter->tasks($value, $board);
                break;
        }

        $textStyle = new OutputFormatterStyle('cyan', 'default');
        $output->getFormatter()->setStyle('text', $textStyle);

        $errorStyle = new OutputFormatterStyle('red', 'default');
        $output->getFormatter()->setStyle('error', $errorStyle);

        $warningStyle = new OutputFormatterStyle('yellow', 'default');
        $output->getFormatter()->setStyle('warning', $warningStyle);

        $board = '';

        foreach ($view as $entry) {
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
        if ($view == []) {
            $output->writeln("<comment>No entries found</comment>");
            return;
        }
        $output->writeln('');
    }
}

<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wildledersessel\Fbmbook\Latex\LatexPrinter;
use Wildledersessel\Fbmbook\Repository\ChatMessageRepositoryInterface;

#[AsCommand(
    name: 'to-latex',
    description: 'Generates the a latex file'
)]
class OutputLatexCommand extends Command
{
    public function __construct(
        private readonly ChatMessageRepositoryInterface $chatMessageRepository,
        private readonly LatexPrinter                   $latexPrinter,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $currentYear = 0;
        $currentMonth = 0;
        $currentDay = 0;

        foreach ($this->chatMessageRepository->findAll() as $msg) {
            $date = $msg->getDateTime();
            $year = $date->format('Y');
            if ($currentYear !== $year) {
                $output->writeln('\newyear{' . $year . '}');
                $currentYear = $year;
                $currentMonth = 0;
                $currentDay = 0;
            }
            $month = $date->format('m');
            if ($currentMonth !== $month) {
                $output->writeln('\newmonth{' . $month . '}');
                $currentMonth = $month;
                $currentDay = 0;
            }
            $day = $date->format('d');
            if ($currentDay !== $day) {
                $output->writeln('\newday{' . $day . '}');
                $currentDay = $day;
            }

            $output->writeln($this->latexPrinter->print($msg));
        }

        return self::SUCCESS;
    }
}

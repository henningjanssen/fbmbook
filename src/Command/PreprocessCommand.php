<?php
declare(strict_types=1);

namespace Wildledersessel\Fbmbook\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('preprocess', 'Generates the database and sort data')]
class PreprocessCommand extends Command
{
    protected function configure()
    {
        $this
            ->addArgument('inpath', InputArgument::REQUIRED, 'Path to the directory containing the exported chat data.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("Hi");

        return self::SUCCESS;
    }
}

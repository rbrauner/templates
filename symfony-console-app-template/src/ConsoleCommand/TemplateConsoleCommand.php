<?php

declare(strict_types=1);

/**
 * Copyright (C) Rafał Brauner
 */

namespace App\ConsoleCommand;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:template',
    description: 'App template',
)]
final class TemplateConsoleCommand extends Command
{
    private ?string $env = null;

    private ?string $lang = null;

    private SymfonyStyle $io;

    #[\Override]
    protected function configure(): void
    {
        $this
            ->addArgument('env', InputArgument::REQUIRED, 'Environment (e.g. local, dev)')
            ->addArgument('lang', InputArgument::REQUIRED, 'Language (e.g. pl, en)')
        ;
    }

    #[\Override]
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->init($input, $output);

            $this->io->writeln('Environment: '.$this->env);
            $this->io->writeln('Language: '.$this->lang);

            $data = [];
            $progressBar = new ProgressBar($this->io, count($data));
            $progressBar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s%/%estimated:-6s% %memory:6s% -- %message%');
            $progressBar->start();
            foreach ($progressBar->iterate($data) as $d) {
                $temp = json_encode($d);
                $progressBar->setMessage('Processing '.$temp);
                // do sth
            }

            $progressBar->finish();
        } catch (\Throwable $throwable) {
            $this->io->error('Error: '.$throwable->getMessage());

            return Command::FAILURE;
        }

        $this->io->success('OK');

        return Command::SUCCESS;
    }

    private function init(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);

        $this->env = null !== $input->getArgument('env') ? (string) $input->getArgument('env') : null;
        $this->lang = null !== $input->getArgument('lang') ? (string) $input->getArgument('lang') : null;
    }
}

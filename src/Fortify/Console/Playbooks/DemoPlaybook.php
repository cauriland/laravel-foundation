<?php

declare(strict_types=1);

namespace CauriLand\Foundation\Fortify\Console\Playbooks;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DemoPlaybook extends Playbook
{
    public function before(): array
    {
        return [
            AccessControlPlaybook::once(),
            ManagementUserPlaybook::once(),
        ];
    }

    public function run(InputInterface $input, OutputInterface $output): void
    {
        $output->writeln('<info>[Playbook] Demo - success</info>');
    }
}

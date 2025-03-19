<?php

namespace App\Console\Commands\Make;

use Spatie\LaravelData\Commands\DataMakeCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'make:request', description: 'Create a new request data class')]
class RequestMakeCommand extends DataMakeCommand
{
    protected $name = 'make:request';

    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/request.stub');
    }

    protected function getOptions(): array
    {
        return [
            [
                'namespace',
                'N',
                InputOption::VALUE_REQUIRED,
                'The namespace (under \App) to place this Data class.',
                config('data.commands.make.namespace', 'Data'),
            ],
            [
                'suffix',
                's',
                InputOption::VALUE_REQUIRED,
                'Suffix the class with this value.',
                'Request',
            ],
            [
                'force',
                'f',
                InputOption::VALUE_NONE,
                'Create the Data class even if the file already exists.',
            ],
        ];
    }
}

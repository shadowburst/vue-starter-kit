<?php

namespace App\Console\Commands\Make;

use Spatie\LaravelData\Commands\DataMakeCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'make:data:resource', description: 'Create a new resource data class')]
class ResourceDataMakeCommand extends DataMakeCommand
{
    protected $name = 'make:resource';

    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/data-resource.stub');
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
                'Resource',
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

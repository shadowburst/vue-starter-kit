<?php

namespace App\Console\Commands\Make;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'make:service', description: 'Create a new service class')]
class ServiceMakeCommand extends GeneratorCommand
{
    protected $name = 'make:service';

    protected $description = 'Create a new service class';

    protected $type = 'Service';

    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/service.stub');
    }

    protected function resolveStubPath($stub): string
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.'/../..'.$stub;
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        $namespace = trim($this->option('namespace'), '\\');

        return trim($rootNamespace.'\\'.$namespace, '\\');
    }

    protected function qualifyClass($name): string
    {
        $suffix = trim($this->option('suffix'));
        if (! empty($suffix) && ! Str::endsWith($name, $suffix)) {
            $name .= $suffix;
        }

        return parent::qualifyClass($name);
    }

    protected function getOptions(): array
    {
        return [
            [
                'namespace',
                'N',
                InputOption::VALUE_REQUIRED,
                'The namespace (under \App) to place this Service class.',
                'Services',
            ],
            [
                'suffix',
                's',
                InputOption::VALUE_REQUIRED,
                'Suffix the class with this value.',
                'Service',
            ],
        ];
    }
}

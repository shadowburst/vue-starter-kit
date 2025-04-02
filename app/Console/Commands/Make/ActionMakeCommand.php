<?php

namespace App\Console\Commands\Make;

use Spatie\QueueableAction\ActionMakeCommand as SpatieActionMakeCommand;

class ActionMakeCommand extends SpatieActionMakeCommand
{
    protected function getStub(): string
    {
        return $this->option('sync')
            ? $this->resolveStubPath('/stubs/action.stub')
            : $this->resolveStubPath('/stubs/action-queued.stub');
    }

    protected function resolveStubPath($stub): string
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.'/../..'.$stub;
    }
}

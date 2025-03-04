<?php

namespace App\Console\Commands\Dev;

use Illuminate\Console\Command;

class DevTypesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:types';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate php / typescript types';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->call('ide-helper:models', ['-R' => true, '-W' => true]);
        $this->call('typescript:transform');

        return self::SUCCESS;
    }
}

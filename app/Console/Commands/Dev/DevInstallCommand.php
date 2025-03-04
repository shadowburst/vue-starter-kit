<?php

namespace App\Console\Commands\Dev;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DevInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup the dev environment';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->call('clear-compiled');
        $this->call('optimize:clear');
        if (! config('app.key')) {
            $this->call('key:generate');
        }
        if (! File::exists(public_path('storage'))) {
            $this->call('storage:link');
        }
        if (! File::exists(base_path('_ide_helper.php'))) {
            $this->call('ide-helper:generate');
        }

        if ($this->components->confirm('Reset database ?')) {
            $this->call('migrate:fresh');
        } else {
            $this->call('migrate');
        }

        $this->call('db:seed');

        if ($this->components->confirm('Generate fake data')) {
            $count = $this->components->askWithCompletion('How many items to create per model ?', [25, 50, 100]);
            User::factory($count)->create();
        }

        return self::SUCCESS;
    }
}

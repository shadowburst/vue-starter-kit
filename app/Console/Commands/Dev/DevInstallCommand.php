<?php

namespace App\Console\Commands\Dev;

use App\Models\Banner;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

use function Laravel\Prompts\alert;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\text;

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

        if (app()->isProduction()) {
            alert('Database will be ignored in production');

            return self::SUCCESS;
        }

        if (confirm('Reset database ?')) {
            $this->call('migrate:fresh');
        } else {
            $this->call('migrate');
        }
        $this->call('db:seed');

        if (! File::exists(base_path('_ide_helper.php'))) {
            $this->call('ide-helper:generate');
        }

        if (confirm('Generate fake data ?')) {
            $count = text(
                label: 'How many items to create per model ?',
                default: 50,
                validate: fn (string $value) => match (true) {
                    intval($value) === 0 => 'Given value must be a positive integer',
                    default              => null
                },
            );
            Banner::factory($count)->create();
            User::factory($count)->create();
        }

        return self::SUCCESS;
    }
}

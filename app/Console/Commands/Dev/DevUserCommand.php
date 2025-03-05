<?php

namespace App\Console\Commands\Dev;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\text;

class DevUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dev:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user for the environment';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $firstName = text(
            label: 'First name',
            default: 'Super',
        );
        $lastName = text(
            label: 'Last name',
            default: 'Admin',
        );
        $email = text(
            label: 'Email',
            default: 'super@admin.com',
            validate: ['email' => ['email']],
        );
        $password = text(
            label: 'Password',
            default: 'password',
        );

        User::factory()->create([
            'first_name' => $firstName,
            'last_name'  => $lastName,
            'email'      => $email,
            'password'   => Hash::make($password),
        ]);

        return self::SUCCESS;
    }
}

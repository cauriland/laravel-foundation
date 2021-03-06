<?php

declare(strict_types=1);

namespace CauriLand\Foundation\Fortify\Console\Commands;

use CauriLand\Foundation\Fortify\Models;
use CauriLand\Foundation\Fortify\Notifications\AccountCreated;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * @codeCoverageIgnore
 */
class CreateUserCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'user:create {name} {--role=*} {--silent} {--domain=cauri.cm}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $domain = strtolower(Arr::first(Arr::wrap($this->option('domain'))));
        $name   = strtolower(Arr::first(Arr::wrap($this->argument('name'))));
        $email  = $name.'@'.$domain;
        $roles  = (array) $this->option('role');

        $isProduction = app()->environment() === 'production';

        if ($this->option('silent') === true || $this->confirm("Do you want to create an account as {$email}?")) {
            $data = $this->getUserData($name, $domain);

            $password = null;
            if ($isProduction) {
                $data['password'] = Hash::make($password = Str::random(32));
            } else {
                $data['password'] = Hash::make('password');
            }

            $user = Models::user()::create($data);

            if (count($roles) > 0) {
                foreach ($roles as $role) {
                    $user->assignRole($role);
                }
            }

            $this->info('The account has been created.');
            if ($isProduction) {
                $this->info('An E-Mail with further instructions has been sent.');

                $user->notify(new AccountCreated($password));
            }
        }
    }

    protected function getUserData(string $name, string $domain): array
    {
        $data = [
            'username'          => $name,
            'email'             => $name.'@'.$domain,
            'email_verified_at' => Carbon::now(),
        ];

        if (Schema::hasColumn('users', 'name')) {
            $data['name'] = ucwords($name);
        }

        return $data;
    }
}

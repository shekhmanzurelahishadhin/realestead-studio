<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create
                            {--name= : Display name}
                            {--email= : Login email}
                            {--password= : Plain password (prompted when omitted)}';

    protected $description = 'Create (or update the password of) an admin panel user';

    public function handle(): int
    {
        $name = $this->option('name') ?: text('Name', required: true);
        $email = $this->option('email') ?: text('Email', required: true);
        $plain = $this->option('password') ?: password('Password', required: true);

        $validator = Validator::make(
            compact('name', 'email') + ['password' => $plain],
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'password' => ['required', 'string', 'min:8'],
            ]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->components->error($error);
            }

            return self::FAILURE;
        }

        $user = User::updateOrCreate(
            ['email' => $email],
            ['name' => $name, 'password' => Hash::make($plain)]
        );

        $this->components->info(
            $user->wasRecentlyCreated
                ? "Admin user {$email} created."
                : "Password updated for existing user {$email}."
        );

        return self::SUCCESS;
    }
}

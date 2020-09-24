<?php

namespace App\Console\Commands;

use App\Role\UserRole;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user
                            {email : The email of the new user}
                            {--a|admin : Make the user an admin}
                            {--p|password=password : New user\'s password}
                            {--N|name=User : New user\'s name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        $role = $this->hasArgument('admin') && $this->argument('admin') ? UserRole::ROLE_ADMIN : UserRole::ROLE_VOTER;
        $password = $this->hasArgument('password') ? $this->argument('password') : 'password';
        $name = $this->hasArgument('name') ? $this->argument('name') : 'User';

        factory(User::class, 1)->create([
            'email' => $email,
            'name' => $name,
            'password' => Hash::make($password),
            'roles' => [$role]
        ]);

        return 0;
    }
}

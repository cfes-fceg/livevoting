<?php

use App\Role\UserRole;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 10)->create();

        factory(App\User::class, 1)->create([
            'email' => 'admin@example.com',
            'name' => 'Admin User',
            'roles' => [UserRole::ROLE_ADMIN]
        ]);

        factory(App\User::class, 1)->create([
            'email' => 'voter@example.com',
            'name' => 'Voting User',
            'roles' => [UserRole::ROLE_VOTER]
        ]);
    }
}

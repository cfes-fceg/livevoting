<?php

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
        factory(App\Models\User::class, 10)->create();

        factory(App\Models\User::class, 1)->create([
            'email' => 'admin@example.com',
            'roles' => [\App\Role\UserRole::ROLE_ADMIN]
        ]);

        factory(App\Models\User::class, 1)->create([
            'email' => 'voter@example.com',
            'roles' => [\App\Role\UserRole::ROLE_VOTER]
        ]);
    }
}

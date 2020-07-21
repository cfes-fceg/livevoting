<?php

use App\Role\UserRole;
use App\User;
use Illuminate\Database\Seeder;

class TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(App\User::class, 10)->create();

        factory(User::class, 1)->create([
            'email' => 'admin@example.com',
            'name' => 'Admin User',
            'roles' => [UserRole::ROLE_ADMIN]
        ]);

        factory(User::class, 1)->create([
            'email' => 'voter@example.com',
            'name' => 'Voting User',
            'roles' => [UserRole::ROLE_VOTER]
        ])->each(function (User $user){
            factory(\App\EngSoc::class, 3)->create([
                'name' => 'Voting user\'s Engineering Society'
            ])->each(function (\App\EngSoc $engSoc) use ($user) {
                $engSoc->voter()->associate($user);
                $engSoc->save();
            });
        });
    }
}

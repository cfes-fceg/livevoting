<?php

use Illuminate\Database\Seeder;

class EngSocsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\EngSoc::class, 50)->create();
    }
}

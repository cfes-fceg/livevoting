<?php

/** @var Factory $factory */

use App\Models\EngSoc;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(EngSoc::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'location' => $faker->address
    ];
});

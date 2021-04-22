<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Patient::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'gender' => 'female',
        'national_id' => $faker->randomNumber,
        'insurance_id' => 1,
        'birth_year' => $faker->year
    ];
});

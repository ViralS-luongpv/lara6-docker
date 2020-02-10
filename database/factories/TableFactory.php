<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Table;
use Faker\Generator as Faker;

$factory->define(Table::class, function (Faker $faker) {

    return [
        'name' => $faker->text,
        'age' => $faker->text,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});

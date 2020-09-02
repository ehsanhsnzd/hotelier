<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\Hotel\app\Models\Item::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'rating' => $faker->numberBetween(0,5),
        'category' => 'hotel',
        'image' => $faker->url,
        'reputation' => $faker->numberBetween(0,1000),
        'reputationBadge' => 'green',
        'price' => $faker->numberBetween(0,500),
        'availability' => $faker->numberBetween(0,20),
    ];
});


$factory->define(\Hotel\app\Models\Location::class, function (Faker $faker) {
    return [
        'city' => strtolower($faker->name),
        'state' => $faker->state,
        'country' => $faker->country,
        'zip_code' => '12345',
        'address' => $faker->address,
    ];
});

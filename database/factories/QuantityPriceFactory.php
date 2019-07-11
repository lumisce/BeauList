<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\QuantityPrice;
use Faker\Generator as Faker;

$factory->define(QuantityPrice::class, function (Faker $faker) {
    return [
        'quantity' => $faker->randomElement(array(3.5, 30, 50, 100, 200)),
        'unit' => $faker->randomElement(array('ml', 'g')),
        'price' => $faker->numberBetween(4, 30) * 1000,
        'currency' => $faker->randomElement(array('KRW')),
    ];
});

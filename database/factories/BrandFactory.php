<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Brand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Faker\Generator as Faker;

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

$factory->define(Brand::class, function (Faker $faker) {
	$name = $faker->company;
	$filepath = 'images/brands/'.preg_replace('/\W+/', '', $name).'.jpg';
	Storage::put($filepath, file_get_contents('http://lorempixel.com/200/200/cats/'));

    return [
        'name' => $name,
        'description' => $faker->catchPhrase,
		'image' => Storage::url($filepath)
    ];
});

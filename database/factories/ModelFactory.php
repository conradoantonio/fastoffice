<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\News::class, function (Faker\Generator $faker) {
	return [
		'title' => $faker->sentence,
		'content' => $faker->paragraph,
		"photo" => "cover_pic.png",
	];
});

$factory->define(App\Models\Faq::class, function (Faker\Generator $faker) {
	return [
		'question' => $faker->sentence,
		'answer' => $faker->paragraph,
	];
});

$factory->define(App\Models\Banner::class, function (Faker\Generator $faker) {
	return [
		"image" => "cover_pic.png",
	];
});
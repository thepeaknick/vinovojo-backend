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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
    ];
});



$factory->define(\App\Article::class, function ($faker) {
    $fake = [
        'name' => $faker->sentence,
    ];

    if (rand() % 2)
        $fake['link'] = $faker->url;
    else
        $fake['text'] = $faker->realText();

    return $fake;
});



$factory->define(\App\Happening::class, function ($faker) {
    $fake = [
        'name' => $faker->sentence,
        'start' => $faker->datetime,
        'end' => $faker->datetime,
        'location' => $faker->address,
        'lat' => $faker->latitude,
        'lng' => $faker->longitude
    ];

    if (rand() % 2) 
        $fake['link'] = $faker->url;
    else 
        $fake['description'] = $faker->realText();

    return $fake;
});



$factory->define(\App\Wine::class, function ($faker) {
    $faker->addProvider(new \FakerRestaurant\Provider\en_US\Restaurant($faker));
    return [
        'name' => $faker->beverageName(),
        'description' => $faker->realText,
        'harvest_year' => $faker->year,
        'serving_temp' => $faker->numberBetween(10, 25),
        'alcohol' => $faker->numberBetween(5, 70),
        'serbia_bottles' => $faker->numberBetween(1, 1000),
        'recommended' => $faker->numberBetween(0, 1),
        'highlighted' => $faker->numberBetween(0, 1),
        'classification_id' => $faker->numberBetween(1, 3)
    ];
});



$factory->define(\App\Category::class, function ($faker) {
    return [
        'name' => $faker->word
    ];
});



$factory->define(\App\Winery::class, function ($faker) {
    return [
        'name' => $faker->company,
        'description' => $faker->realText,
        'recommended' => $faker->numberBetween(0, 1),
        'address' => $faker->address,
        'ponpet' => '09 - 17',
        'sub' => '10 - 15',
        'ned' => 'ne radi',
        'contact_person' => $faker->name,
        'contact' => $faker->e164PhoneNumber,
        'highlighted' => $faker->numberBetween(0, 1)
    ];
});



$factory->define(\App\Pin::class, function ($faker) {
    return [
        'lat' => $faker->latitude,
        'lng' => $faker->longitude
    ];
});



$factory->define(\App\WinePath::class, function ($faker) {
    return [
        'name' => ucfirst($faker->word),

        // 'start_lat' => $faker->latitude,
        // 'start_lng' => $faker->longitude,

        // 'start_name' => $faker->company,
        // 'start_address' => $faker->address,

        // 'end_lat' => $faker->latitude,
        // 'end_lng' => $faker->longitude,

        // 'end_name' => $faker->company,
        // 'end_address' => $faker->address,
    ];
});



$factory->define(App\Area::class, function ($faker) {
    return [
        'name' => $faker->country,
        'description' => $faker->realText
    ];
});



$factory->define(App\PointOfInterest::class, function ($faker) {
    return [
        'name' => $faker->company,
        'address' => $faker->address,
        'type' => $faker->numberBetween(20, 21)
    ];
});
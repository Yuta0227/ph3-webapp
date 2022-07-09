<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Language;
use Faker\Generator as Faker;

$factory->define(Language::class, function (Faker $faker) {
    $id = 1;
    $language = 'language';
    $color_code = '#000000';
    return [
        'id' => $id,
        'language' => $language,
        'color_code' => $color_code,
    ];
});

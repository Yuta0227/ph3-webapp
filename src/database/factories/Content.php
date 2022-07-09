<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Content;
use Faker\Generator as Faker;

$factory->define(Content::class, function (Faker $faker) {
    $id = 1;
    $content = 'content';
    $color_code = '#000000';
    return [
        'id' => $id,
        'content' => $content,
        'color_code' => $color_code,
    ];
});

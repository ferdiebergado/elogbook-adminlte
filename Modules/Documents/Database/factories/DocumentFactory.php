<?php
namespace Modules\Documents\Database\factories;

use Faker\Generator as Faker;

$factory->define(Modules\Documents\Entities\Document::class, function (Faker $faker) {
    return [
        'doctype_id' => $faker->numberBetween(1, 45),
        'details' => $faker->text(150),
        'persons_concerned' => $faker->name(),
        'additional_info' => $faker->paragraph(),
        'office_id' => $faker->randomElement([7,9])
    ];
});

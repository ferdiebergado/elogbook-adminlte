<?php
namespace Modules\Documents\Database\factories;

use Faker\Generator as Faker;

$factory->define(Modules\Documents\Entities\Transaction::class, function (Faker $faker) {
    return [
        'document_id' => $faker->randomNumber(),
        'doctype_id' => $faker->numberBetween(1,45),
        'task' => $faker->randomElement(['I', 'O']),
        'from_to_office' => $faker->numberBetween(1, 75),
        'date' => $faker->dateTime(),
        'action' => $faker->text(250),
        'action_to_be_taken_' => $faker->text(250),
        'by' => $faker->text(150),
        'office_id' => $faker->numberBetween(1, 75),
        'pending' => $faker->boolean()
    ];
});

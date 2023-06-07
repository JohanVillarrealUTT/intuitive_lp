<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Entities\Subscriber::class, function (Faker $faker) {
    return [
        'area_id' => '1',
        'full_name' => $faker->name,
		'gender' => $faker->word,
		'address' => $faker->word,
        'phone' => $faker->unique()->tollFreePhoneNumber,
        'email' => $faker->unique()->safeEmail,
        'school_degree' => $faker->word,
		'referenced_by' => $faker->word,
		'referenced_by_name' => $faker->word,
		'schedule_availability' => $faker->boolean,
		'applied_before' => $faker->boolean,
        'computer_usage' => $faker->randomDigit,
		'jobs' => '[{"name":"1","role":"2","entry_date":"3","exit_date":"4"}]',
		//admin related
		'candidate' => $faker->boolean,
        'rejected' => $faker->boolean,
    ];
});

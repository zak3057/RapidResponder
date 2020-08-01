<?php

use Faker\Generator as Faker;

$factory->define(App\Contact::class, function (Faker $faker) {
    $scheduled_date = $faker->dateTimeBetween('+1day', '+1year');
    $item = [
        'A001','A002','A003','A004','A005','A006','A007','A008','A009','A010','A011','A012','A013','A014','A015','A016'
    ];

    return [
        'name' => '山田太郎山田太郎',
        'mail' => $faker->email,
        'tel' => $faker->isbn10,
        'item' => $item[rand(0, 15)],
        'body' => $faker->realText(512),
        'status' => '未対応',
        'created_at' => $scheduled_date->format('Y-m-d H:i:s'),
        'updated_at' => $scheduled_date->format('Y-m-d H:i:s'),
    ];
});

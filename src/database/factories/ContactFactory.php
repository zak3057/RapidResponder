<?php

use Faker\Generator as Faker;

$factory->define(App\Contact::class, function (Faker $faker) {
    $scheduled_date = $faker->dateTimeBetween('1day', '1year');
    $item = [
        'A001','A002','A003','A004','A005','A006','A007','A008','A009','A010','A011','A012','A013','A014','A015','A016'
    ];
    $status = [
        '未対応',
        '対応中',
        '対応済み',
    ];

    return [
        'name' => '山田太郎山田太郎',
        'mail' => $faker->safeEmail,
        'tel' => '09011112222',
        'item' => $item[rand(0, 15)],
        'body' => $faker->realText(512),
        'status' => $status[rand(0, 2)],
        'created_at' => $scheduled_date->format('Y-m-d H:i:s'),
        'updated_at' => $scheduled_date->format('Y-m-d H:i:s'),
    ];
});

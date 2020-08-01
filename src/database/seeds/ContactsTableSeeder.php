<?php

use Illuminate\Database\Seeder;
use App\Contact;
use Faker\Factory as Faker;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 10000件作成
        factory(Contact::class, 1000)->create();
    }
}

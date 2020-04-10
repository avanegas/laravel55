<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        User::truncate();

        foreach(range(1, 20) as $i) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('secret'),
                'api_token' => str_random(60)
            ]);
        }
    }
}
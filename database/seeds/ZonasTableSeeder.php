<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Zona;

class ZonasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        Zona::truncate();

        foreach(range(1, 5) as $i) {
            Zona::create([
                'name' => $faker->name,
                'description' => $faker->paragraph,
                'user_id' => $i
            ]);
        }
    }
}

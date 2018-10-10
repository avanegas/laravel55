<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Data\Transporte;

class TransportesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        Transporte::truncate();

        foreach(range(1, 10) as $i) {
            Transporte::create([
                'zona_id' => mt_rand(1, 5),
                'name' => $faker->unique()->name,
                'unidad' => $faker->word,
                'tipo' => $faker->word,
                'tarifa' => $faker->randomFloat($nbMaxDecimals = 5, $min = 0, $max = 400)
            ]);
        }
    }
}

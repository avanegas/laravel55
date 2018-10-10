<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Data\GrupoObrero;
use App\Models\Data\Obrero;

class GrupoObrerosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        GrupoObrero::truncate();
        Obrero::truncate();

        foreach(range(1, 5) as $i) {
            GrupoObrero::create([
                'zona_id' => $i,
                'name' => $faker->unique()->name,
                'description' => $faker->paragraph
            ]);
            foreach(range(1, 10) as $i) {
                Obrero::create([
                    'grupo_obrero_id' => mt_rand(1, 5),
                    'name' => $faker->unique()->name,
                    'jornalhora' => $faker->randomFloat($nbMaxDecimals = 5, $min = 0, $max = 80),
                    'factor' => '1.37525'
                ]);
            }
        }
    }
}

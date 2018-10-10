<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Data\GrupoEquipo;
use App\Models\Data\Equipo;

class GrupoEquiposTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        GrupoEquipo::truncate();
        Equipo::truncate();

        foreach(range(1, 5) as $i) {
            GrupoEquipo::create([
                'zona_id' => $i,
                'name' => $faker->unique()->name,
                'description' => $faker->paragraph
            ]);
            foreach(range(1, 10) as $i) {
                Equipo::create([
                    'grupo_equipo_id' => mt_rand(1, 5),
                    'name' => $faker->unique()->name,
                    'marca' => $faker->name,
                    'tipo' => $faker->name,
                    'tarifa' => $faker->randomFloat($nbMaxDecimals = 5, $min = 0, $max = 400)
                ]);
            }
        }
    }
}

<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Data\GrupoMaterial;
use App\Models\Data\Material;

class GrupoMaterialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        GrupoMaterial::truncate();
        Material::truncate();

        foreach(range(1, 5) as $i) {
            GrupoMaterial::create([
                'zona_id' => $i,
                'name' => $faker->unique()->name,
                'description' => $faker->paragraph
            ]);
            foreach(range(1, 10) as $i) {
                Material::create([
                    'grupo_material_id' => mt_rand(1, 5),
                    'name' => $faker->unique()->name,
                    'unidad' => $faker->word,
                    'precio' => $faker->randomFloat($nbMaxDecimals = 5, $min = 0, $max = 400)
                ]);
            }
        }
    }
}

<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Precio\GrupoPrecio;
use App\Models\Precio\Precio;
use App\Models\Precio\PrecioEquipo;
use App\Models\Precio\PrecioMaterial;
use App\Models\Precio\PrecioObrero;
use App\Models\Precio\PrecioTransporte;

class GrupoPreciosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        GrupoPrecio::truncate();

        Precio::truncate();
        PrecioEquipo::truncate();
        PrecioMaterial::truncate();
        PrecioObrero::truncate();
        PrecioTransporte::truncate();

        foreach(range(1, 5) as $i) {
            GrupoPrecio::create([
                'zona_id' => $i,
                'name' => $faker->unique()->name,
                'description' => $faker->paragraph
            ]);
        }

        foreach(range(1, 10) as $n) {
            Precio::create([
                'user_id'=> mt_rand(1, 5),
                'grupo_precio_id'=> mt_rand(1, 5),
                'name' => $faker->name,
                'unidad' => $faker->word,
                'detalle' => $faker->sentence,
                'directo' => 1.25,
                'indirecto' => 2.40
            ]);

            foreach(range(1, mt_rand(3, 5)) as $j) {
                PrecioEquipo::create([
                    'precio_id' => $n,
                    'equipo_id' => mt_rand(1, 10),
                    'name' => $faker->name,
                    'tarifa' => 1.20,
                    'cantidad' => 2.42,
                    'rendimiento' => 1.28,
                    'total' => 6.42
                ]);
            }

            foreach(range(1, mt_rand(3, 5)) as $k) {
                PrecioMaterial::create([
                    'precio_id' => $n,
                    'material_id' => mt_rand(1, 10),
                    'name' => $faker->name,
                    'unidad' => $faker->word,
                    'precio' => 2.1,
                    'cantidad' => 2.5,
                    'total' => 5.24
                ]);
            }

            foreach(range(1, mt_rand(3, 5)) as $l) {
                PrecioObrero::create([
                    'precio_id' => $n,
                    'obrero_id' => mt_rand(1, 10),
                    'name' => $faker->name,
                    'jornalhora' => 2.15,
                    'cantidad' => 1.20,
                    'rendimiento' => 2.05,
                    'total' => 6.42
                ]);
            }

            foreach(range(1, mt_rand(3, 5)) as $m) {
                PrecioTransporte::create([
                    'precio_id' => $n,
                    'transporte_id' =>mt_rand(1, 10),
                    'name' => $faker->name,
                    'unidad' => $faker->word,
                    'tarifa' => 2.64,
                    'cantidad' => 2.4,
                    'distancia' => 2.20,
                    'total' => 6.42,
                ]);
            }
        }

    }
}

<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Proyecto\Proyecto;
use App\Models\Proyecto\ProyectoRubro;

class ProyectosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        Proyecto::truncate();
        ProyectoRubro::truncate();

        foreach(range(1, 20) as $i) {
            $rubros = collect();
            foreach(range(1, mt_rand(3, 10)) as $j) {
                $cantidad = $faker->numberBetween(1, 100);
                $precio = $faker->numberBetween(1, 999);
                $rubros->push(new ProyectoRubro([
                    'proyecto_id' => $i,
                    'precio_id' => mt_rand(1,5),
                    'orden' => $j,
                    'rubro' => $faker-> sentence($nbWords = 4, $variableNbWords = true),
                    'unidad' => $faker-> word(),
                    'cantidad' => $cantidad,
                    'precio' =>  $precio,
                    'total' => ($cantidad*$precio)
                ]));
            }

            $subTotal = $rubros->sum('total');
            $descuento = $faker->numberBetween(1, 20);
            $total = $subTotal - $descuento;

            $proyecto = Proyecto::create([
                'user_id'=> mt_rand(1, 5),
                'name' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'contratante' => $faker->catchPhrase,
                'ubicacion' => $faker->sentence($nbWords = 4, $variableNbWords = true),
                'oferente' => $faker->name(),
                'entrega' => $faker->date(),
                'referencial' => $faker->numberBetween(1000, 200000),
                'indirecto' => $faker->numberBetween(10, 20),
                'descuento' => $descuento,
                'distancia' => $faker->numberBetween(1, 100),
                'sub_total' => $subTotal,
                'gran_total' => $total,
                'formato' => $faker->numberBetween(1, 4),
                'precision' => $faker->numberBetween(2, 4),
                'representante' => $faker->name()
            ]);

            $proyecto->rubros()->saveMany($rubros);
        }

    }
}

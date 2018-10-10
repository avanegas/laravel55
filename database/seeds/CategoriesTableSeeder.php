<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Post\Category;
use App\Models\Post\Post;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        Category::truncate();
        Post::truncate();

        foreach(range(1, 5) as $i) {
            $category =Category::create([
                'name' => $faker->unique()->word(),
                'description' => $faker->paragraph
            ]);
            foreach(range(1, 10) as $j) {
                Post::create([
                    'category_id'=> $category->id,
                    'user_id'=> $i,
                    'name' => $faker->sentence,
                    'content' => $faker->paragraph,
                    'tags' => 'tema,nuevo,prueba,estudio,color',
                    'image' => 'test.png'
                ]);
            }
        }
    }
}

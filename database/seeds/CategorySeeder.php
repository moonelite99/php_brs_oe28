<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'literary',
            ],
            [
                'name' => 'economic',
            ],
            [
                'name' => 'historical',
            ],
            [
                'name' => 'religional',
            ],
            [
                'name' => 'foreign_language',
            ],
            [
                'name' => 'comic',
            ],
            [
                'name' => 'life_skills',
            ],
            [
                'name' => 'it',
            ],
            [
                'name' => 'cultural',
            ],
            [
                'name' => 'medicine',
            ],
        ]);
    }
}

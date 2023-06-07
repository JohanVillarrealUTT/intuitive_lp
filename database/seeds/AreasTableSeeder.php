<?php

use Illuminate\Database\Seeder;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas')->insert([
            'name' => 'Linea de producción',
            'slug' => 'linea-de-produccion',
            'value' => 'linea-de-produccion',
        ]);
    }
}

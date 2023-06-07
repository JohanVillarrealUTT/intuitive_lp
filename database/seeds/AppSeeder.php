<?php

use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('app_configs')->insert([
            'created_at' => now(),
            'updated_at' => now(),
            'register_enable' => trUE,
        ]);
    }
}

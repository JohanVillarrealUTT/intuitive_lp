<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(AreasSeeder::class);
        $this->call(AppSeeder::class);
        // factory('App\Entities\Subscriber', 1000)->create();
    }
}

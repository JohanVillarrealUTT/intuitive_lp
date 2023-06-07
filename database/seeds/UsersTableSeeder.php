<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		//administrador
		//recruiter
		//applicant

		DB::table('users')->insert([
				'name' => 'root',
                'email' => 'admin@intuitivemexicali.com',
				'password' => bcrypt('atraetalento.com'),
				'role' => 'admin'
		]);

	}
}

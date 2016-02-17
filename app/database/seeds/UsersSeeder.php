<?php

class UsersSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();
		
		DB::table('users')->truncate();
		
		User::create(array(
			'active' => 1,
			'email' => 'test@test.ru',
			'password' => 'admins',
			'group' => '1',
		));
	}
	
}

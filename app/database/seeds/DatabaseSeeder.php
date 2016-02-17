<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('fields')->truncate();
		DB::table('regs')->truncate();
		DB::table('settings')->truncate();
		
		$this->call('PagesSeeder');
		$this->call('UsersSeeder');
	}

}

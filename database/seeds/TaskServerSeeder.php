<?php

use Illuminate\Database\Seeder;

class TaskServerSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('task_servers')->insert([
			'server_ip' => '127.0.0.1',
		]);
	}
}

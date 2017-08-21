<?php

use Illuminate\Database\Seeder;

class TaskUserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('task_users')->insert([
			'user_name'  => 'chenbing',
			'user_email' => 'chenbing@yongche.com',
			'user_phone' => 18513852359,
			'created_at' => date('Y-m-d h:i:s'),
			'updated_at' => date('Y-m-d h:i:s'),
		]);
	}
}

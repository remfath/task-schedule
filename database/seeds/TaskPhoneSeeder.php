<?php

use Illuminate\Database\Seeder;

class TaskPhoneSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('task_phones')->insert([
			[
				'task_id'     => 1,
				'task_phones' => '18513852359',
				'created_at'  => date('Y-m-d h:i:s'),
				'updated_at'  => date('Y-m-d h:i:s'),
			],
			[
				'task_id'     => 2,
				'task_phones' => '18513852359',
				'created_at'  => date('Y-m-d h:i:s'),
				'updated_at'  => date('Y-m-d h:i:s'),
			],
			[
				'task_id'     => 3,
				'task_phones' => '18513852359',
				'created_at'  => date('Y-m-d h:i:s'),
				'updated_at'  => date('Y-m-d h:i:s'),
			],
			[
				'task_id'     => 6,
				'task_phones' => '18513852359',
				'created_at'  => date('Y-m-d h:i:s'),
				'updated_at'  => date('Y-m-d h:i:s'),
			],
		]);
	}
}

<?php

use Illuminate\Database\Seeder;

class TaskGroupSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('task_groups')->insert([
			'group_name'       => '测试组',
			'group_desc'       => '任务管理测试专用分组',
			'created_at' => date('Y-m-d h:i:s'),
			'updated_at' => date('Y-m-d h:i:s'),
		]);
	}
}

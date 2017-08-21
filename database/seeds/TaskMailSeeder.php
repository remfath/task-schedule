<?php

use Illuminate\Database\Seeder;

class TaskMailSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('task_mails')->insert([
			[
				'task_id'        => 1,
				'task_mails_to'  => 'chenbing@yongche.com',
				'task_mails_cc'  => 'remfath@gmail.com',
				'task_mails_bcc' => '894619376@qq.com',
				'created_at'     => date('Y-m-d h:i:s'),
				'updated_at'     => date('Y-m-d h:i:s'),
			],
			[
				'task_id'        => 2,
				'task_mails_to'  => 'chenbing@yongche.com',
				'task_mails_cc'  => 'remfath@gmail.com',
				'task_mails_bcc' => '',
				'created_at'     => date('Y-m-d h:i:s'),
				'updated_at'     => date('Y-m-d h:i:s'),
			],
			[
				'task_id'        => 3,
				'task_mails_to'  => 'chenbing@yongche.com',
				'task_mails_cc'  => '',
				'task_mails_bcc' => '894619376@qq.com',
				'created_at'     => date('Y-m-d h:i:s'),
				'updated_at'     => date('Y-m-d h:i:s'),
			],
			[
				'task_id'        => 5,
				'task_mails_to'  => '',
				'task_mails_cc'  => '',
				'task_mails_bcc' => '',
				'created_at'     => date('Y-m-d h:i:s'),
				'updated_at'     => date('Y-m-d h:i:s'),
			],
		]);
	}
}

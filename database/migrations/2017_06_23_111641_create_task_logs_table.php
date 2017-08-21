<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskLogsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('task_logs', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('task_id')->comment('任务ID');
			$table->text('task_output')->comment('输出');
			$table->text('task_error')->comment('错误信息');
			$table->tinyInteger('task_run_status')->comment('执行状态，0表示成功，-1表示失败');
			$table->dateTime('task_start_time')->comment('开始时间');
			$table->dateTime('task_end_time')->comment('结束时间');
			$table->timestamps();
            $table->softDeletes();
			$table->index('task_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('task_logs');
	}
}

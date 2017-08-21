<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tasks', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('group_id')->nullable()->comment('任务分组');
			$table->integer('user_id')->comment('任务所属人');
			$table->integer('server_id')->comment('环境服务器');
			$table->string('task_title')->comment('名称');
			$table->enum('task_type', ['script', 'email'])->comment('任务类型。script表示普通脚本，email表示发送邮件,');
			$table->string('task_lang')->comment('任务语言，如bash, php, python');
			$table->enum('commend_type', ['file', 'command', 'url'])->comment('运行类型。 file表示脚本文件，command表示直接命令，url表示api调用或者访问某个url');
			$table->string('task_command')->comment('任务内容。脚本路径、url或者命令');
			$table->string('task_params')->nullable()->comment('任务参数。post方式：name=Jack&age=20；其他方式原文传入。可以传入变量，比如#TODAY#表示今天');
			$table->enum('http_method', ['get', 'post'])->nullable()->comment('http请求方式');
			$table->string('task_dependencies')->nullable()->comment('任务依赖脚本id');
			$table->integer('task_priority')->nullable()->comment('任务优先级');
			$table->text('task_desc')->nuallable()->commemt('任务描述');
			$table->string('task_run_time')->comment('cron执行时间');
			$table->dateTime('prev_time')->nullable()->comment('上次执行时间');
			$table->dateTime('next_time')->nullable()->comment('下次执行时间');
			$table->tinyInteger('task_status')->default(0)->comment('状态。0表示停用, 1表示启用');
			$table->timestamps();
            $table->softDeletes();
			$table->index('group_id');
			$table->index('user_id');
			$table->index('server_id');
			$table->index('task_type');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('task_infos');
	}
}

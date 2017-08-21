<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskMailsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('task_mails', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('task_id')->comment('任务ID');
			$table->string('task_mails_to')->nullable()->comment('收件人');
			$table->string('task_mails_cc')->nullable()->comment('抄送人');
			$table->string('task_mails_bcc')->nullable()->comment('密送人');
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
		Schema::dropIfExists('task_mails');
	}
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('task_users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('user_name')->comment('用户姓名');
			$table->text('user_email')->comment('用户邮箱');
			$table->bigInteger('user_phone')->comment('用户手机');
			$table->timestamps();
            $table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('task_users');
	}
}

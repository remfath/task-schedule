<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskPhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_phones', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('task_id')->comment('任务ID');
			$table->string('task_phones')->nullable()->comment('警报接收人电话');
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
        Schema::dropIfExists('task_phones');
    }
}

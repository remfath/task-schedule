<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_servers', function (Blueprint $table) {
            $table->increments('id');
            $table->ipAddress('server_ip')->comment('服务器ip地址');
            $table->string('server_username')->nullable()->comment('ssh账户');
            $table->string('server_password')->nullable()->nullable()->comment('ssh密码');
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
        Schema::dropIfExists('task_servers');
    }
}

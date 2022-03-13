<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administers', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('管理者ID');
            $table->string('name', 255)->comment('氏名');
            $table->string('login_id', 255)->comment('ログインID');
            $table->string('password', 255)->comment('パスワード');
            $table->timestamps();
            $table->softDeletes()->comment('削除日時');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administers');
    }
}

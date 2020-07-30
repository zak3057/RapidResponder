<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('メッセージ番号');
            $table->unsignedBigInteger('contact_id')->comment('問い合わせ番号');
            $table->unsignedBigInteger('user_id')->comment('ユーザー番号');
            $table->string('title', 200)->comment('タイトル');
            $table->string('body', 4000)->comment('本文');
            $table->dateTime('created_at')->nullable()->comment('送信日');
            $table->dateTime('updated_at')->nullable()->comment('更新日時');

            $table->foreign('contact_id')->references('id')->on('contacts');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}

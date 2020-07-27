<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id')->comment('問い合わせ番号');
            $table->string('name', 16)->comment('氏名');
            $table->string('mail', 200)->comment('メールアドレス');
            $table->string('tel', 32)->comment('電話番号');
            $table->string('item', 16)->comment('製品種別');
            $table->string('body', 2000)->comment('問い合わせ内容');
            $table->string('status', 16)->comment('対応状況');
            $table->dateTime('date_time')->comment('問い合わせ日時');
            $table->unsignedBigInteger('user_id')->nullable()->comment('対応者');

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
        Schema::dropIfExists('contacts');
    }
}

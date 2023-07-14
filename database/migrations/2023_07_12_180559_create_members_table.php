<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->integer('id')->autoIncrement()->comment('会員ID');
            $table->string('name_sei')->comment('氏名（姓）');
            $table->string('name_mei')->comment('氏名（名）');
            $table->string('nickname')->comment('ニックネーム');
            $table->integer('gender')->comment('性別');
            $table->string('password')->comment('パスワード');
            $table->string('email')->comment('メールアドレス');
            $table->integer('auth_code')->nullable()->comment('認証コード');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}

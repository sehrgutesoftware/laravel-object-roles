<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_user', function (Blueprint $table) {
            $table->timestamps();

            $table->foreignId('role_id');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('object_type')->nullable();
            $table->foreignId('object_id')->nullable();

            $table->boolean('global')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('role_user');
    }
}

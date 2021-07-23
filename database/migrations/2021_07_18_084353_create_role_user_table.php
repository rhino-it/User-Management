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
            $table->id();
//            $table->unsignedBigInteger('role_id');
//            $table->unsignedBigInteger('user_id');

//            these 2 change those 4
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamps();
//            many to many
//            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
//            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        if you put constraints in separate migrations
//        Schema::table('role_user', function (Blueprint $table){
//            $table->dropForeign('role_user_role_id_foreign');
//            $table->dropForeign('role_user_user_id_foreign');
//        });
        Schema::dropIfExists('role_user');
    }
}

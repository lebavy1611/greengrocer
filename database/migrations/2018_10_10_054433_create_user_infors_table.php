<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInforsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_infors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                    ->references('id')->on('users')
                    ->onDelete('no action');
            $table->string('fullname', 45)->charset('utf8')->collation('utf8_unicode_ci');
            $table->date('birthday')->nullable();
            $table->string('avatar', 45)->nullable();
            $table->string('address')->nullable();
            $table->string('phone', 13)->nullable();
            $table->tinyInteger('gender');
            $table->timestamps();
            $table->softDeletes('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_infors');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username', 32);
            $table->string('fullname', 45)->charset('utf8')->collation('utf8_unicode_ci');
            $table->string('email', 45)->unique();
            $table->string('password');
            $table->string('phone', 13)->nullable();
            $table->string('address')->nullable();
            $table->tinyInteger('gender');
            $table->tinyInteger('active');
            $table->rememberToken();
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
        Schema::dropIfExists('managers');
    }
}

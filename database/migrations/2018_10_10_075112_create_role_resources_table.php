<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_resources', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('role_id');
            $table->foreign('role_id')
                    ->references('id')->on('roles')
                    ->onDelete('no action');
            $table->unsignedInteger('resource_id');
            $table->foreign('resource_id')
                    ->references('id')->on('resources')
                    ->onDelete('no action');
            $table->tinyInteger('can_view');
            $table->tinyInteger('can_add');
            $table->tinyInteger('can_edit');
            $table->tinyInteger('can_del');
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
        Schema::dropIfExists('role_resources');
    }
}

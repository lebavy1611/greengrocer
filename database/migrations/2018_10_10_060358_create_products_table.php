<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45)->charset('utf8')->collation('utf8_unicode_ci');
            $table->unsignedInteger('shop_id');
            $table->foreign('shop_id')
                    ->references('id')->on('shops')
                    ->onDelete('no action');
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')
                    ->references('id')->on('categories')
                    ->onDelete('no action');            
            $table->text('describe')->nullable()->charset('utf8')->collation('utf8_unicode_ci');
            $table->unsignedInteger('price');
            $table->string('origin', 45)->nullable();
            $table->unsignedInteger('quantity');
            $table->date('imported_date');
            $table->date('expired_date');
            $table->tinyInteger('active');
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
        Schema::dropIfExists('products');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id');
            $table->foreign('customer_id')
                    ->references('id')->on('users')
                    ->onDelete('no action');
            $table->string('full_name', 45)->charset('utf8')->collation('utf8_unicode_ci');
            $table->string('phone', 13)->nullable();
            $table->string('address')->charset('utf8')->collation('utf8_unicode_ci');
            $table->dateTime('delivery_time');
            $table->string('note')->charset('utf8')->collation('utf8_unicode_ci');
            $table->unsignedInteger('processing_status')->default(1);
            $table->unsignedInteger('payment_status');
            $table->unsignedInteger('payment_method_id');
            $table->foreign('payment_method_id')
                    ->references('id')->on('payment_methods')
                    ->onDelete('no action');
            $table->unsignedInteger('coupon_id')->nullable();
            $table->foreign('coupon_id')
                    ->references('id')->on('coupons')
                    ->onDelete('no action');
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
        Schema::dropIfExists('orders');
    }
}

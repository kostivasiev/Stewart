<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Scripe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('companies', function ($table) {
          $table->string('stripe_id')->nullable();
          $table->string('card_brand')->nullable();
          $table->string('card_last_four')->nullable();
          $table->timestamp('trial_ends_at')->nullable();

          $table->integer('creator_user_id')->nullable();
          $table->integer('max_num_of_users');
          $table->integer('max_num_of_equipment');
          $table->integer('max_num_of_stations');
      });

      Schema::create('subscriptions', function ($table) {
          $table->increments('id');
          $table->integer('company_id');
          $table->string('name');
          $table->string('stripe_id');
          $table->string('stripe_plan');
          $table->integer('quantity');
          $table->timestamp('trial_ends_at')->nullable();
          $table->timestamp('ends_at')->nullable();
          $table->timestamps();
      });

      Schema::create('products', function ($table) {
          $table->increments('id');
          $table->string('name');
          $table->string('description');
          $table->float('price');
          $table->timestamps();
      });

      Schema::create('orders', function ($table) {
          $table->increments('id');
          $table->integer('user_id');
          $table->integer('status');
          $table->string('name');
          $table->string('address1');
          $table->string('address2');
          $table->string('city');
          $table->string('state');
          $table->string('zip');
          $table->string('phone');
          $table->string('tracking_number');
          $table->timestamps();
      });

      Schema::create('order_product', function ($table) {
          $table->increments('id');
          $table->integer('order_id')->unsigned()->default(0);;
          $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
          $table->integer('product_id')->unsigned()->default(0);;
          $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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

      Schema::dropIfExists('order_product');
      Schema::dropIfExists('orders');
      Schema::dropIfExists('products');
      Schema::dropIfExists('subscriptions');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLotsTable extends Migration {

	public function up(){
		
		Schema::create('lots', function(Blueprint $table){
			$table->increments('id');
			$table->integer('user_id')->unsigned()->default(0)->index();
			$table->integer('product_id')->unsigned()->default(0)->index();
			
			$table->string('title',200)->nullable();
			$table->text('description')->nullable();
			$table->text('attributes')->nullable();
			
			$table->integer('type_lot')->unsigned()->default(1)->nullable();

			$table->integer('quantity')->unsigned()->default(0)->index();
			$table->string('shop_price',20)->nullable();
			$table->string('auction_start_price',20)->nullable();
			$table->string('auction_blitc_price',20)->nullable();
			$table->string('auction_period',20)->nullable();
			
			$table->string('seo_url',255)->nullable();
			$table->string('seo_title',255)->nullable();
			$table->text('seo_description')->nullable();
			$table->text('seo_keywords')->nullable();
			$table->string('seo_h1')->nullable();
			$table->boolean('publication')->default(1)->unsigned()->nullable();
			$table->string('template',100)->nullable();
			$table->string('language',10)->nullable();
			$table->timestamps();
			
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
		});
	}

	public function down(){
		Schema::drop('lots');
	}
}

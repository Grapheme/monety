<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLotImagesTable extends Migration {

	public function up(){
		
		Schema::create('lot_images',function(Blueprint $table){

			$table->increments('id');
			$table->integer('lot_id')->unsigned()->default(0)->index();
			$table->integer('user_id')->unsigned()->default(0)->index();
			
			$table->integer('sort')->default(0)->unsigned()->nullable();
			$table->string('title',255)->nullable();
			$table->text('description')->nullable();
			$table->text('paths')->nullable();
			$table->text('attributes')->nullable();
			
			$table->boolean('publication')->default(1)->unsigned()->nullable();
			$table->timestamps();
			
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('lot_id')->references('id')->on('lots')->onDelete('cascade');
		});
	}

	public function down(){
		Schema::drop('lot_images');
	}
}

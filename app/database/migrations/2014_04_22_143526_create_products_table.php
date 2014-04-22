<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	public function up(){
		
		Schema::create('products', function(Blueprint $table){
			$table->increments('id');
			$table->integer('catalog_id')->unsigned()->default(0)->index();
			$table->integer('category_group_id')->unsigned()->default(0)->index();
			
			$table->integer('sort')->default(0)->unsigned()->nullable();
			$table->text('data_fields')->nullable();
			$table->string('tags',255)->nullable();
			
			$table->string('seo_url',255)->nullable();
			$table->string('seo_title',255)->nullable();
			$table->text('seo_description')->nullable();
			$table->text('seo_keywords')->nullable();
			$table->string('seo_h1')->nullable();
			$table->boolean('publication')->default(1)->unsigned()->nullable();
			$table->timestamps();
		});
	}

	public function down(){
		Schema::drop('products');
	}

}

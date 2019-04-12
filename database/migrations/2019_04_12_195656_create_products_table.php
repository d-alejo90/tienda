<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('category_id')->default(0)->index('category_id');
			$table->string('name', 100);
			$table->string('description', 250)->nullable();
			$table->decimal('price', 10)->default(0.00);
			$table->decimal('weight', 10)->default(0.00);
			$table->decimal('qty', 10)->default(0.00);
			$table->simple_array('post_type');
			$table->simple_array('state');
			$table->bigInteger('creator_id')->unsigned()->index('creator_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}

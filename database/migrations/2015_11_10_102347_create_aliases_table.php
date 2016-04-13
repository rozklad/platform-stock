<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAliasesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stock_aliases', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('usage')->nullable();
			$table->integer('min')->nullable()->default('0');
			$table->integer('max')->nullable()->default('0');
			$table->integer('available')->nullable()->default(0);
			$table->string('alias')->nullable()->default('255');
			$table->string('product_id')->default('*');
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
		Schema::drop('aliases');
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStockOpnameTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stock_opname', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->integer('buy_price');
			$table->dateTime('date')->nullable();
			$table->integer('item_size')->nullable();
			$table->string('note')->nullable();
			$table->float('qty', 10, 0)->nullable();
			$table->integer('sell_price');
			$table->integer('stock_opname_id')->nullable();
			$table->char('stock_opname_status', 1)->nullable();
			$table->integer('inventory')->nullable()->index('FK4wgd44i8krfkqd2qi3n6dqo8c');
			$table->integer('item_color_id')->nullable()->index('FK4ggxydiovf45umho7eb9mgl7l');
			$table->integer('item_id')->nullable()->index('FK6gc3j1j6qjorvk48cqd70o2dq');
			$table->integer('satuan_id')->nullable()->index('FKqi6xy0wuhvejureql4vibcd4s');
			$table->integer('warehouse_id')->nullable()->index('FK1ygkjrhfp915s6gu074psjycy');
			$table->dateTime('deletedOn')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('stock_opname');
	}

}

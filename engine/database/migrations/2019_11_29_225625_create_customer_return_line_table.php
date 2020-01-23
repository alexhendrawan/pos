<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerReturnLineTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_return_line', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->float('qty', 10, 0)->nullable();
			$table->integer('customer_return_header_id')->nullable()->index('FK4wi392aouw2oebbkqr9ffpob2');
			$table->integer('item_stock_id')->nullable()->index('FKcmu8t6quhwxi661dr7bui9pxa');
			$table->integer('returprice');
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
		Schema::drop('customer_return_line');
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalesOrderLineTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sales_order_line', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->boolean('bonus');
			$table->string('code')->nullable();
			$table->float('diskon', 10, 0);
			$table->float('price_per_satuan_id', 10, 0)->nullable();
			$table->float('qty', 10, 0)->nullable();
			$table->float('qty_pending_send', 10, 0);
			$table->float('retur', 10, 0);
			$table->integer('item_stock_id')->nullable()->index('FKag5pgvjkkkx9ty2nv47mgw1x9');
			$table->integer('sales_order_header_id')->nullable()->index('FK50tsphfo10wuqi97msvcyu02v');
			$table->float('sales_per_satuan_id', 10, 0);
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
		Schema::drop('sales_order_line');
	}

}

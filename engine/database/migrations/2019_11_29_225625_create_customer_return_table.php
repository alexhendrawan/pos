<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerReturnTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_return', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->string('faktur')->nullable();
			$table->float('hargafifo', 10, 0);
			$table->bigInteger('noreturn');
			$table->float('qty', 10, 0);
			$table->string('status')->nullable();
			$table->dateTime('tanggal')->nullable();
			$table->integer('item_stock_id')->nullable()->index('FKmh7t31dxv116qeegdtt5lg1ny');
			$table->integer('sales_order_header_id')->nullable()->index('FKawil9r0148pih4gfqjw6t87a1');
			$table->integer('sales_order_line_id')->nullable()->index('FK845r0bq9d7ur8pe3ous4t36lw');
			$table->integer('warehouse_id')->nullable()->index('FKlrbdgytjktf8a29jo84x48jn');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customer_return');
	}

}

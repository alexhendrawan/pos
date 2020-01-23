<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerShipmentReturnTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_shipment_return', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->integer('fifo');
			$table->bigInteger('nomorfaktur');
			$table->bigInteger('nomorso');
			$table->bigInteger('nomorsoline');
			$table->bigInteger('noreturn');
			$table->float('qtyreturn', 10, 0);
			$table->string('status')->nullable();
			$table->dateTime('tanggalreturn')->nullable();
			$table->integer('warehouse_id')->nullable()->index('FK91l0lsxqxrntn05mj5vf1wmi3');
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
		Schema::drop('customer_shipment_return');
	}

}

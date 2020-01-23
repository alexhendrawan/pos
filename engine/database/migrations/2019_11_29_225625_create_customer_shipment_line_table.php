<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerShipmentLineTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_shipment_line', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->integer('customer_shipment_line_id')->nullable();
			$table->float('qty', 10, 0)->nullable();
			$table->integer('customer_shipment_header_id')->nullable()->index('FK7bxejj7papu1yjou9ye6sn6ss');
			$table->integer('satuan_id')->nullable()->index('FKqs87kxcjlnucbllflesrpom6k');
			$table->integer('sales_order_line_id')->nullable()->index('FKkgdd74qs6hj2n5c5td7xix680');
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
		Schema::drop('customer_shipment_line');
	}

}

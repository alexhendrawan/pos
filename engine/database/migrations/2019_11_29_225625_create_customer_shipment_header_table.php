<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerShipmentHeaderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_shipment_header', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->integer('customer_shipment_header_id')->nullable();
			$table->integer('customer_shipment_no')->nullable();
			$table->integer('customer_shipment_status')->nullable();
			$table->dateTime('date')->nullable();
			$table->string('suratjalan')->nullable();
			$table->integer('sales_order_header_id')->nullable()->index('FK7howhk6nnet1mlr1r4p37ol0s');
			$table->integer('sales1_id')->nullable()->index('FKay65wshlpn4xtjh7bm02o9qyx');
			$table->integer('sales2_id')->nullable()->index('FK8cetnuwjsqtpfflh0f1v04sdy');
			$table->integer('printed')->default(0);
			$table->string('sj')->nullable();
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
		Schema::drop('customer_shipment_header');
	}

}

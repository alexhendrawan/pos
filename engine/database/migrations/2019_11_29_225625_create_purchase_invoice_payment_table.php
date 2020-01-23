<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePurchaseInvoicePaymentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('purchase_invoice_payment', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->string('cek')->nullable();
			$table->string('cekcair')->nullable();
			$table->string('giro')->nullable();
			$table->string('girocair', 2)->nullable();
			$table->string('invoice_payment_no')->nullable();
			$table->string('invoice_payment_status', 2)->nullable();
			$table->string('note')->nullable();
			$table->string('payment_id', 2)->nullable();
			$table->float('payment_value', 10, 0)->nullable();
			$table->string('purchase_invoice_no')->nullable();
			$table->string('status', 2)->nullable();
			$table->string('tanggalcair')->nullable();
			$table->integer('bank_id')->nullable()->index('FKq0dg6qyxd6r2wo6grdp1miim5');
			$table->integer('purchase_invoice_header_id')->nullable()->index('FKf66rxclno9un93eeoec29vud7');
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
		Schema::drop('purchase_invoice_payment');
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalesInvoicePaymentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sales_invoice_payment', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->integer('diskon')->nullable()->default(0);
			$table->string('giro')->nullable();
			$table->string('girocair')->nullable();
			$table->dateTime('jatuhtempo')->nullable();
			$table->string('note')->nullable()->default('-');
			$table->string('payment_id')->nullable()->default('C');
			$table->float('payment_value', 10, 0)->nullable();
			$table->string('sales_invoice_no')->nullable();
			$table->integer('sales_invoice_payment_id');
			$table->integer('sales_invoice_payment_no');
			$table->string('sales_invoice_paymnet_status')->nullable();
			$table->string('tanggalcair')->nullable();
			$table->integer('bank_cash_id')->nullable()->index('FKpdqm4dfoi46hr7o3c3srlsi8u');
			$table->integer('sales_dp_id')->nullable()->index('FKrfcrh4r61niy9g1m6wvug2vvj');
			$table->integer('sales_order_header_id')->nullable()->index('FKcl8ofw8qi05x2ctko5tbtr08k');
			$table->integer('diskonpersen');
			$table->integer('diskonrupiah');
			$table->string('sales_invoice_payment_status')->nullable();
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
		Schema::drop('sales_invoice_payment');
	}

}

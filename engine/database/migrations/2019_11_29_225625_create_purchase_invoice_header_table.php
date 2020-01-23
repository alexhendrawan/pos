<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePurchaseInvoiceHeaderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('purchase_invoice_header', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->dateTime('due_date')->nullable();
			$table->string('internal_invoice_no')->nullable();
			$table->dateTime('invoice_date')->nullable();
			$table->float('invoice_total', 10, 0)->nullable();
			$table->float('paid_total', 10, 0)->nullable();
			$table->string('payment_terms', 4)->nullable();
			$table->string('purchase_invoice_status', 4)->nullable();
			$table->float('sub_total', 10, 0)->nullable()->default(0);
			$table->string('supplier_invoice_no')->nullable();
			$table->integer('poheader_id')->nullable()->index('FKafglswak96sr6uo2b3e2va4rv');
			$table->float('retur', 10, 0)->nullable()->default(0);
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
		Schema::drop('purchase_invoice_header');
	}

}

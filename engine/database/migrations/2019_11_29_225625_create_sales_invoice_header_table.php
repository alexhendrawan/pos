<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalesInvoiceHeaderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sales_invoice_header', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->float('dp_total', 10, 0)->nullable();
			$table->dateTime('due_date')->nullable();
			$table->string('internal_invoice_no')->nullable();
			$table->dateTime('invoice_date')->nullable();
			$table->string('invoice_no')->nullable();
			$table->float('invoice_total', 10, 0)->nullable();
			$table->float('paid_total', 10, 0)->nullable();
			$table->string('payment_terms', 4)->nullable();
			$table->string('purchase_invoice_status', 4)->nullable();
			$table->float('sub_total', 10, 0)->nullable();
			$table->string('suratjalan')->nullable();
			$table->integer('customer_id')->nullable()->index('FKomkelhm9y1t5k2vw2ptgma0vb');
			$table->integer('sales_order_header_id')->nullable()->index('FKtlutgydy40m7e79tm50mbhj6w');
			$table->integer('supplier_id')->nullable()->index('FK2p0hd9vx25kexvh49ra28vdcq');
			$table->float('grosssale', 10, 0);
			$table->float('netto', 10, 0);
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
		Schema::drop('sales_invoice_header');
	}

}

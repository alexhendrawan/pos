<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePurchaseInvoiceLineTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('purchase_invoice_line', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->timestamp('updatedOn')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->integer('price_per_satuan_id');
			$table->float('qty', 10, 0);
			$table->integer('sell_per_satuan_id');
			$table->integer('po_header_id')->nullable()->index('FK6hbqrck2n3abi710ht0m12icm');
			$table->integer('po_line_id')->nullable()->index('FKrxfvak60efim3eafsc20nawlf');
			$table->integer('purchase_invoice_header_id')->nullable()->index('FKkm440vf2d2ok3qjsov0a5md9o');
			$table->integer('satuan_id')->nullable()->index('FKbmgo7bug42innxvvrexuv6b4e');
			$table->integer('warehouse_id')->nullable()->index('FK277ueoj2k3w6vh784f9cwe6r9');
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
		Schema::drop('purchase_invoice_line');
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSupplierReturnLineTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('supplier_return_line', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->float('qty', 10, 0)->nullable();
			$table->integer('retur_price');
			$table->integer('supplier_return_line_no')->nullable();
			$table->integer('item_stock_id')->nullable()->index('FKijmsdnhmm7sb8d2tejije1sdk');
			$table->integer('supplier_return_header_id')->nullable()->index('FK44go9mucpf9j9wbaokw6t3gpq');
			$table->integer('purchase_invoice_line_id')->nullable()->index('FK8r57rhni5ffnxshmshnojckpw');
			$table->integer('item_id')->nullable()->index('FKndajhflaicpd5d2nbnk47mfs6');
			$table->integer('warehouse_id')->nullable()->index('FKb0y2pudebb6pca66hpkq6pgdd');
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
		Schema::drop('supplier_return_line');
	}

}

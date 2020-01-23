<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalesInvoiceLineTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sales_invoice_line', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->float('price_per_satuan_id', 10, 0)->nullable();
			$table->float('qty', 10, 0)->nullable();
			$table->float('sales_per_Satuan_id', 10, 0);
			$table->integer('item_color_id')->nullable()->index('FKefaworfcj7uon0120jyxi2udp');
			$table->integer('item_id')->nullable()->index('FKksxf77d1y6j5by83r2nm4a0bf');
			$table->integer('item_stock_id')->nullable()->index('FKbspx2f2mtn1ddf0olj8ep3a6e');
			$table->integer('sales_invoice_header_id')->nullable()->index('FKnieg7mqkuuh34daxi5q5ntxl0');
			$table->integer('satuan_id')->nullable()->index('FK940gr38gruf1mtpfq84ppvnqf');
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
		Schema::drop('sales_invoice_line');
	}

}

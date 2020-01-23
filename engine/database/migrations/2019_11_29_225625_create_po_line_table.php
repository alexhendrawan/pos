<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePoLineTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('po_line', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->integer('po_line_no')->nullable();
			$table->float('qty_buy', 10, 0)->nullable();
			$table->float('qty_get', 10, 0)->nullable();
			$table->integer('inventory_property_id')->nullable()->index('FKg3th2nrvwh16k1xs9nt5kuckb');
			$table->integer('item_stock_id')->nullable()->index('FK8vyjs9vgpxpo577927c8d8bx9');
			$table->integer('po_header_id')->nullable()->index('FK7iy3de0le4v93xl2yjxlenkng');
			$table->integer('satuan_id')->nullable()->index('FK1g1xi6nwhrr1obqoa4j7do3dp');
			$table->integer('price_per_satuan_id')->default(0);
			$table->integer('sell_per_satuan_id')->default(0);
			$table->integer('penerimaan');
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
		Schema::drop('po_line');
	}

}

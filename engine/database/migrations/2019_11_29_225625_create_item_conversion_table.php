<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemConversionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('item_conversion', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->char('item_conversion_no', 1)->nullable();
			$table->integer('item_conversion_status')->nullable();
			$table->integer('new_item_stock_id')->nullable();
			$table->string('note')->nullable();
			$table->float('qty', 10, 0)->nullable();
			$table->float('qty_converted', 10, 0)->nullable();
			$table->integer('item_conversion_id')->nullable()->index('FKmh8ctt7v2a8v1aihoimlpqtoe');
			$table->integer('item_id')->nullable()->index('FKgdcmg1qvjsybu72vw1x0r9cmi');
			$table->integer('new_satuan_id')->nullable()->index('FK51nqqwl0jj6uxb0jab2b9v2mp');
			$table->integer('warehouse_id')->nullable()->index('FKel5a1ilcxxcginmpyhn1lwndv');
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
		Schema::drop('item_conversion');
	}

}

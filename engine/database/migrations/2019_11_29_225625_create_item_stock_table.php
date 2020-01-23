<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemStockTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('item_stock', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->string('code')->nullable();
			$table->integer('purchase_price');
			$table->float('qty', 10, 0)->nullable();
			$table->integer('sell_price');
			$table->float('size', 10, 0);
			$table->string('stock_type')->nullable();
			$table->integer('item_id')->nullable()->index('FK9ueoosftu721oai7q1esf6v6w');
			$table->integer('satuan_id')->nullable()->index('FKqchjytyigs3uy8belv8yg1t2d');
			$table->integer('warehouse_id')->nullable()->index('FKrainmmxhotrvjhjxmnflkeijf');
			$table->dateTime('expired')->nullable();
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
		Schema::drop('item_stock');
	}

}

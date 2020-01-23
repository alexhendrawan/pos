<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInventoryPropertyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inventory_property', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->string('code')->nullable();
			$table->float('threshold_bottom', 10, 0);
			$table->float('threshold_top', 10, 0);
			$table->integer('brand_id')->nullable()->index('FKebgu2t5l63lxyu8gdwh5qc2wb');
			$table->integer('item_color_id')->nullable()->index('FK3fxmand3aqddpjb3j807nolo1');
			$table->integer('item_id')->nullable()->index('FK3xpijb1e1w1hd7m7fup129ktg');
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
		Schema::drop('inventory_property');
	}

}

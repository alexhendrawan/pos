<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePoHeaderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('po_header', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->string('customer')->nullable();
			$table->string('po_no')->nullable();
			$table->string('po_status', 2)->nullable();
			$table->float('po_total', 10, 0)->nullable();
			$table->float('po_total_paid', 10, 0)->nullable();
			$table->integer('supplier_id')->nullable()->index('FKn64fscpr68pda092girl4s8ao');
			$table->integer('Warehouse_id')->nullable()->index('FK8ehh1i9grbgarfm3l122mek7d');
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
		Schema::drop('po_header');
	}

}

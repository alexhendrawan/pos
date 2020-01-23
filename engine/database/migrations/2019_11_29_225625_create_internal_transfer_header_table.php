<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInternalTransferHeaderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('internal_transfer_header', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->integer('internal_transfer_no')->nullable();
			$table->dateTime('receive_date')->nullable();
			$table->string('receiver')->nullable();
			$table->dateTime('send_date')->nullable();
			$table->string('sender')->nullable();
			$table->string('transfer_status')->nullable();
			$table->integer('dest_warehouse_id')->nullable()->index('FK41v85368jl4mj8giqby2422s6');
			$table->integer('init_warehouse_id')->nullable()->index('FKbb1466j86l2wujjnqdodq1jdl');
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
		Schema::drop('internal_transfer_header');
	}

}

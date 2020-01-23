<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePoDpTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('po_dp', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->string('giro')->nullable();
			$table->dateTime('jatuh_tempo')->nullable();
			$table->string('note')->nullable();
			$table->integer('payment_id')->nullable();
			$table->string('pembayaran', 4)->nullable();
			$table->string('po_dp_no')->nullable();
			$table->float('po_dp_remain', 10, 0)->nullable();
			$table->float('po_dp_value', 10, 0)->nullable();
			$table->integer('po_no')->nullable();
			$table->string('status', 4)->nullable();
			$table->string('tanggalcair')->nullable();
			$table->integer('bank_id')->nullable()->index('FKgxctsqcc9a67l5jq7fkuwr8lw');
			$table->integer('po_header_id')->nullable()->index('FKjp9k63c4j2pfdapuwytc0vk1s');
			$table->dateTime('jatuhtempo')->nullable();
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
		Schema::drop('po_dp');
	}

}

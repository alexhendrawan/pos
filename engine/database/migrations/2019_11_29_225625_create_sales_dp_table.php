<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalesDpTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sales_dp', function(Blueprint $table)
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
			$table->string('sales_dp_no')->nullable();
			$table->float('sales_dp_remain', 10, 0)->nullable();
			$table->float('sales_dp_value', 10, 0)->nullable();
			$table->integer('sales_no')->nullable();
			$table->string('status', 4)->nullable();
			$table->string('tanggalcair')->nullable();
			$table->integer('bank_id')->nullable()->index('FKkk8gm8g3jer8sfi5ti5wmvlrs');
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
		Schema::drop('sales_dp');
	}

}

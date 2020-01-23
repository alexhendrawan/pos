<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBankCashTransferTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bank_cash_transfer', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->string('bank_cash_transfer_no')->nullable();
			$table->string('bank_cash_transfer_status')->nullable();
			$table->string('note')->nullable();
			$table->float('transfer_amount', 10, 0)->nullable();
			$table->integer('dest_bank_cash_id')->nullable()->index('FKpgl5wvhu0ompxro872udtdym');
			$table->integer('init_bank_cash_id')->nullable()->index('FKmalpyl2nc7hpwomxmohn6hdu9');
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
		Schema::drop('bank_cash_transfer');
	}

}

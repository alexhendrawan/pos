<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBankCashAdjustmentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bank_cash_adjustment', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->float('adjustment_ammount', 10, 0)->nullable();
			$table->string('adjustment_status')->nullable();
			$table->string('bank_cash_adjustment_no')->nullable();
			$table->string('notes')->nullable();
			$table->integer('bank_cash_id')->nullable()->index('FKet2ru3lvxo02kvunx0jcgwtg8');
			$table->string('adjusment_status')->nullable();
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
		Schema::drop('bank_cash_adjustment');
	}

}

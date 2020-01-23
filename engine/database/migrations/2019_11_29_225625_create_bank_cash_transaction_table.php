<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBankCashTransactionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bank_cash_transaction', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->float('balance', 10, 0)->nullable();
			$table->float('credit', 10, 0)->nullable();
			$table->float('debit', 10, 0)->nullable();
			$table->string('note')->nullable();
			$table->string('transaction_no')->nullable();
			$table->integer('bank_cash_id')->nullable()->index('FK151a6mg0qk3h170axdr2f0lnj');
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
		Schema::drop('bank_cash_transaction');
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBankCashPaymentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bank_cash_payment', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->integer('cheque_currentaccount_cashed')->nullable();
			$table->string('cheque_currentaccount_duedate')->nullable();
			$table->float('cheque_currentaccount_no', 10, 0)->nullable();
			$table->dateTime('confirmation_date')->nullable();
			$table->integer('payment_method')->nullable();
			$table->integer('payment_status')->nullable();
			$table->float('payment_total', 10, 0)->nullable();
			$table->string('payment_type')->nullable();
			$table->integer('taxable')->nullable();
			$table->integer('bank_cash')->nullable()->index('FKi85yer08mjxryciwsrju4xg6t');
			$table->integer('transaction_id')->nullable()->index('FKp8tc7it0plhea095yy8qra0r2');
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
		Schema::drop('bank_cash_payment');
	}

}

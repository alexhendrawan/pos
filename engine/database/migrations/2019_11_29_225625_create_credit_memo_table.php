<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCreditMemoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('credit_memo', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->string('credit_memo_no')->nullable();
			$table->string('credit_memo_status')->nullable();
			$table->float('remain', 10, 0)->nullable();
			$table->float('total', 10, 0)->nullable();
			$table->integer('supplier_id')->nullable()->index('FKkcgbbtflc6dpub7w16kmj7eaq');
			$table->integer('customer_id')->nullable()->index('FKcptojt8pcglromx7o1c61fv4h');
			$table->integer('customer_return_header_id')->nullable()->index('FK4p9wjrs1rkvqqbcr4u726yf0f');
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
		Schema::drop('credit_memo');
	}

}

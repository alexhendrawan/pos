<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDebitMemoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('debit_memo', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->string('debit_memo_no')->nullable();
			$table->string('debit_memo_status')->nullable();
			$table->float('remain', 10, 0)->nullable();
			$table->float('total', 10, 0)->nullable();
			$table->integer('supplier_id')->nullable()->index('FKsfc5sdx4lgpo2m6g9646486j3');
			$table->integer('supplier_code')->nullable()->index('FKqq912137yw9988lgcpn1nkekm');
			$table->integer('supplier_return_header_id')->nullable()->index('FKs2wn1bbj5r0ikyepi1dbr8qhu');
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
		Schema::drop('debit_memo');
	}

}

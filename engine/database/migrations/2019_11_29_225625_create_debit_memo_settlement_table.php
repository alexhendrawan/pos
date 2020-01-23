<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDebitMemoSettlementTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('debit_memo_settlement', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->string('faktur')->nullable();
			$table->string('status')->nullable();
			$table->dateTime('tanggal')->nullable();
			$table->integer('debitmemo_id')->nullable()->index('FK4yafoivc599objqobdk9k6jg1');
			$table->integer('purchase_invoice_header_id')->nullable()->index('FKbybepgev76n2wdwexh79nref9');
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
		Schema::drop('debit_memo_settlement');
	}

}

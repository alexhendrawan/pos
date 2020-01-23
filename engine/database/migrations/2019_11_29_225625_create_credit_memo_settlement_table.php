<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCreditMemoSettlementTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('credit_memo_settlement', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->string('faktur')->nullable();
			$table->string('status')->nullable();
			$table->dateTime('tanggal')->nullable();
			$table->integer('creditmemo_id')->nullable()->index('FKo563jkakwi8pocwoq0jtsws7v');
			$table->integer('sales_id')->nullable()->index('FKoux8p7ce2s0p0uv9c14wkl93h');
			$table->integer('credit_memo_id')->nullable()->index('FKdtomrcixqj2klfca8so47gqia');
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
		Schema::drop('credit_memo_settlement');
	}

}

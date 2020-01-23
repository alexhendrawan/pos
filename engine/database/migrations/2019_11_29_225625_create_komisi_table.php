<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKomisiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('komisi', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->timestamp('updatedOn')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->bigInteger('jumlah');
			$table->integer('sales_invoice_payment_id')->nullable()->index('FK7wbdwhkvtxkaufkjx1449f6j2');
			$table->integer('user_id')->nullable()->index('FKmnc6cnieunwklkm7unr8jyqx6');
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
		Schema::drop('komisi');
	}

}

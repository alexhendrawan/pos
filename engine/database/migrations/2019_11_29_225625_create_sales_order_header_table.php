<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSalesOrderHeaderTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sales_order_header', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->timestamp('updatedOn')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->float('diskon', 10, 0);
			$table->dateTime('due_date')->nullable();
			$table->string('intnomorsales')->nullable();
			$table->string('nomorsales')->nullable();
			$table->dateTime('order_date')->nullable();
			$table->float('payment_remain', 10, 0);
			$table->string('payment_terms')->nullable();
			$table->string('pos')->nullable();
			$table->float('retur', 10, 0);
			$table->string('status')->nullable();
			$table->float('total_dp', 10, 0);
			$table->float('total_paid', 10, 0);
			$table->float('total_sales', 10, 0);
			$table->integer('bank_id')->nullable()->index('FKrn9vhk11atkok5tpg1aps8lbn');
			$table->integer('customer_id')->nullable()->index('FKo3n8aq4x57on0fou8slyywbo7');
			$table->float('modal', 10, 0);
			$table->integer('print')->default(0);
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
		Schema::drop('sales_order_header');
	}

}

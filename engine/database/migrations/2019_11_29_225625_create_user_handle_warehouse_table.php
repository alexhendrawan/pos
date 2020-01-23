<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserHandleWarehouseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_handle_warehouse', function(Blueprint $table)
		{
			$table->integer('username');
			$table->integer('warehouse_id')->index('FK4bk4co9bx2wt2l77q18mcyb40');
			$table->primary(['username','warehouse_id']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_handle_warehouse');
	}

}

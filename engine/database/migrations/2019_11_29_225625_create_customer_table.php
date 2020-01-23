<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->timestamp('updatedOn')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->string('creditlimit')->nullable();
			$table->string('customer_address')->nullable();
			$table->string('customer_code')->nullable();
			$table->integer('customer_id')->default(0);
			$table->string('customer_phone_no')->nullable()->default('-');
			$table->integer('dp')->default(0);
			$table->integer('loanday');
			$table->string('name')->nullable();
			$table->integer('city_id')->nullable()->index('FKt79b5wvqbf38jtkjx36vp9vam');
			$table->integer('sales_id')->nullable()->index('FKr1p65vp2cghbyoiujksc74vxn');
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
		Schema::drop('customer');
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->timestamp('updatedOn')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->string('address')->nullable();
			$table->string('displayName')->nullable();
			$table->bigInteger('komisi');
			$table->string('password')->nullable();
			$table->string('remember_token')->nullable();
			$table->string('telephone')->nullable();
			$table->string('username')->nullable();
			$table->integer('role_id')->nullable()->index('FKn82ha3ccdebhokx3a8fgdqeyy');
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
		Schema::drop('user');
	}

}

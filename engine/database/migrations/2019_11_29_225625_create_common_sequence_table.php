<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommonSequenceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('common_sequence', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->integer('sequence_max_value');
			$table->integer('sequence_min_value');
			$table->integer('sequence_next_value');
			$table->string('table_name')->nullable();
			$table->integer('warehouse_id')->nullable()->index('FKh1k0gv0793pwy1rrc66bcdonh');
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
		Schema::drop('common_sequence');
	}

}

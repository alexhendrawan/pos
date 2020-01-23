<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStockMutationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stock_mutation', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->char('in_out', 1)->nullable();
			$table->string('notes')->nullable();
			$table->float('qty', 10, 0)->nullable();
			$table->integer('stock_mutation_id')->nullable();
			$table->integer('item_id')->nullable()->index('FKs5uuqwgbgncvfc80sk3f3aqo4');
			$table->integer('item_stock_id')->nullable()->index('FKsxuugsuu6qg0cf5lsh844c0xa');
			$table->integer('warehouse_id')->nullable()->index('FKkoyoek62hctgqvjfbqifbb58b');
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
		Schema::drop('stock_mutation');
	}

}

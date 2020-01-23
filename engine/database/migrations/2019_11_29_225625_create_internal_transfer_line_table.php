<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInternalTransferLineTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('internal_transfer_line', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->dateTime('updatedOn')->nullable();
			$table->integer('internal_transfer_line_id')->nullable();
			$table->integer('item_size')->nullable();
			$table->float('qty_receive', 10, 0)->nullable();
			$table->float('qty_send', 10, 0)->nullable();
			$table->integer('destination_item_stock_id')->nullable()->index('FKdajxcn8jp0vjjbrwb8ota938l');
			$table->integer('init_item_stock_id')->nullable()->index('FKhwu953gij8sseianp4mqwhxsj');
			$table->integer('internal_transfer_header_id')->nullable()->index('FKstc8ncf4hmsq1jwv6xr6ny5bf');
			$table->integer('intransit_item_stock_id')->nullable()->index('FKkcdcwmw98ghum5um77se8cc76');
			$table->integer('item_color_id')->nullable()->index('FK28ducegmxk2vtasjjptg95fob');
			$table->integer('item_id')->nullable()->index('FK88y935dyk475cp6ujdbjhsx4n');
			$table->integer('satuan_id')->nullable()->index('FK2layk5qnbttdcljkh7obs5cmd');
			$table->integer('category_id')->nullable()->index('FK7gspd5q0ixlif0fbs29ffgv1d');
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
		Schema::drop('internal_transfer_line');
	}

}

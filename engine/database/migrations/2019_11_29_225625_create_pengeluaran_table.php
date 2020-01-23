<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePengeluaranTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pengeluaran', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('createdBy')->nullable();
			$table->dateTime('createdOn')->nullable();
			$table->string('updatedBy')->nullable();
			$table->timestamp('updatedOn')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->string('detail')->nullable();
			$table->integer('jumlah');
			$table->string('nama')->nullable();
			$table->string('no_bukti')->nullable();
			$table->dateTime('tanggal')->nullable();
			$table->integer('bankcash_id')->nullable()->index('FKse8bpmd9mbvs6n9cn0ruhqnw4');
			$table->integer('inventaris_id')->nullable()->index('FKlau33h6x6owa2ak0nvq42xwbi');
			$table->integer('kategori_pengeluaran_id')->nullable()->index('FKr2e1h2o3jcpa8rw6sbk8av9f8');
			$table->integer('user_id')->nullable()->index('FK9og7rsldivna623lf7i57lkyg');
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
		Schema::drop('pengeluaran');
	}

}

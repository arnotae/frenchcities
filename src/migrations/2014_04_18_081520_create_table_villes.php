<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVilles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('villes', function(Blueprint $table) {
			$table->increments('id');
			$table->string('postcode', 5)->index();
			$table->string('insee', 5)->index();
			$table->string('name', 255)->index();
			$table->string('slug', 255);
			$table->string('region', 255);
			$table->string('region_code', 255);
			$table->string('department', 255);
			$table->string('department_code', 255);
			$table->string('longitude');
			$table->string('latitude');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('villes');
	}

}

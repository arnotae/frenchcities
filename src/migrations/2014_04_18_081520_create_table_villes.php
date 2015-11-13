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
			$table->string('insee', 5);
			$table->string('article', 10);
			$table->string('name', 255)->index();
			$table->string('article_up', 10);
			$table->string('name_up', 255)->index();
			$table->string('slug', 255)->index();
			$table->string('region', 255);
			$table->string('region_code', 20);
			$table->string('department', 255);
			$table->string('department_code', 20);
			$table->string('longitude');
			$table->string('latitude');
			$table->timestamps();
		});

		Schema::create('departements', function(Blueprint $table) {
			$table->increments('id');
			$table->string('code', 5)->index();
			$table->string('name', 255)->index();
			$table->string('name_up', 255)->index();
			$table->string('slug', 255)->index();
			$table->string('chief_place', 255);
			$table->string('region_code', 20)->index();
			$table->timestamps();
		});

		Schema::create('regions', function(Blueprint $table) {
			$table->increments('id');
			$table->string('code', 5)->index();
			$table->string('name', 255)->index();
			$table->string('name_up', 255)->index();
			$table->string('slug', 255)->index();
			$table->string('chief_place', 255);
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
		Schema::drop('departements');
		Schema::drop('regions');
	}

}

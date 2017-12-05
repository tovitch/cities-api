<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('departments', function (Blueprint $table) {
			$table->increments('id');
			$table->string('type');
			$table->string('name');
			$table->string('slug');
			$table->string('code');
			$table->timestamps();
		});

		Schema::create('city_department', function (Blueprint $table) {
			$table->integer('city_id');
			$table->integer('department_id');
			$table->primary(['city_id', 'department_id']);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
        Schema::dropIfExists('city_department');
    }
}

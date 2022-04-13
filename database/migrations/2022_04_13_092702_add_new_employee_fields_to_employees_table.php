<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewEmployeeFieldsToEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('password')->default('$2a$12$0m3Gug/7ssrKRFwTjipiTOQ0dcB9JeABj.JEqYD9BqE8BIUOooIMa'); //12345678
            $table->string('fb_url')->nullable();
            $table->string('li_url')->nullable();
            $table->string('tt_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(
                'password',
                'fb_url',
                'li_url',
                'tt_url',
             );
        });
    }
}

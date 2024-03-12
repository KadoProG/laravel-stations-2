<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReservationsExistColumnToSheets extends Migration
{
    public function up()
    {
        Schema::table('sheets', function (Blueprint $table) {
            $table->boolean('reservations_exist')->default(false);
        });
    }

    public function down()
    {
        Schema::table('sheets', function (Blueprint $table) {
            $table->dropColumn('reservations_exist');
        });
    }
}

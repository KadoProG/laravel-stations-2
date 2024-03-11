<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('date')->comment('上映日');
            $table->unsignedBigInteger('schedule_id')->comment('スケジュールID');
            $table->foreign('schedule_id')->references('id')->on('schedules');
            $table->index('schedule_id');

            $table->unsignedBigInteger('sheet_id')->comment('シートID');
            $table->foreign('sheet_id')->references('id')->on('sheets');
            $table->index('sheet_id');

            $table->string('email', 255)->comment('予約者メールアドレス');
            $table->string('name', 255)->comment('予約社名');
            $table->boolean('is_canceled')->comment('予約キャンセル済み')->default(false);

            $table->timestamps();

            // 複合ユニークキーの追加
            $table->unique(['sheet_id', 'schedule_id', 'is_canceled']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}

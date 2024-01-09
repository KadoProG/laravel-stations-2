<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('movies', function (Blueprint $table) {
      $table->id();
      $table->string('title', 100)->comment('タイトル');
      $table->unique("title", "movies_title_unique");
      $table->text('image_url')->comment('画像URL');
      $table->integer('published_year')->comment('公開年');
      $table->boolean('is_showing')->comment('上映中か否か');
      $table->text('description')->comment('概要');

      // 外部キー制約を追加
      $table->unsignedBigInteger('genre_id');
      $table->foreign('genre_id')->references('id')->on('genres');
      $table->index('genre_id');

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
    Schema::dropIfExists('movies');
  }
}

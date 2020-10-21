<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopeebooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopeebooks', function (Blueprint $table) {
            $table->id();
            $table->text('link');
            $table->bigInteger('book_id');
            $table->bigInteger('shop_id');
            $table->bigInteger('tiki_book_id');
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
        Schema::dropIfExists('shopeebooks');
    }
}

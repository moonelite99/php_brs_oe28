<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditBookUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('book_user', function (Blueprint $table) {
            $table->integer('rating')->nullable()->change();
            $table->integer('status')->default(config('read.unread'))->change();
            $table->integer('favorite')->default(config('default.not_fav'))->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('book_user', function (Blueprint $table) {
            $table->integer('rating')->change();
            $table->tinyInteger('status')->change();
            $table->tinyInteger('favorite')->change();
        });
    }
}

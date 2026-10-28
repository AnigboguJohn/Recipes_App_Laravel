<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailsToPosts extends Migration
{
    /** Category, servings, difficulty and calories for each recipe, plus a photo credit for demo photos. */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('category', 30)->default('Lunch')->index();
            $table->unsignedTinyInteger('servings')->nullable();
            $table->string('difficulty', 10)->nullable();
            $table->unsignedSmallInteger('calories')->nullable();
            $table->string('photo_credit')->nullable();
            $table->string('photo_credit_url')->nullable();
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['category', 'servings', 'difficulty', 'calories', 'photo_credit', 'photo_credit_url']);
        });
    }
}

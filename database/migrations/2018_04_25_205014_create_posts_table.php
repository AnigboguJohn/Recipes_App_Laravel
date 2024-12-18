<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // the file will be created with basic information
        //for the table in the database
        //----- We need to create the database
        //----- use phpmyadmin to create just the database    

        Schema::create('posts', function (Blueprint $table) {
            //once we run the migration    php artisan migrate
            // all the information we define here
            //will populate the database
            //and also it will add more tables
            
            //we need to tell Laravel what to use as a database
            // you would need to check out the types of the variables you want to define
            $table->increments('id');
            $table->string('title'); // a simple string
            $table->string('preptime'); 
            $table->mediumText('description'); //medium height text
            $table->mediumText('ingredients');
            $table->longText('preparation');// long height text
            $table->string('cover'); // this is for the image, we just want the name as a string
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
        Schema::dropIfExists('posts');
    }
}

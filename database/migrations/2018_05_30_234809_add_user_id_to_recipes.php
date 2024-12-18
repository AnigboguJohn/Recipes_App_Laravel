<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserIdToRecipes extends Migration
{

    //before being able to set the user to be able to register
    //and stored in the database we need to add another column
    //to the recipes table
    //this column will tell laravel how to join tables

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //add the column named "user_id" to the recipes
        //add to the posts table the next column
        Schema::table('posts', function($table){
            //the name is "user_id"
            $table->integer("user_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //drop the table
        Schema::table('posts', function($table){
            $table->dropColumn("user_id");
        });
    }
}
// run the migration and we will have a new column in the posts table

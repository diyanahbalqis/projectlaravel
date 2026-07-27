<?php

//use Illuminate\Database\Migrations\Migration;
//use Illuminate\Database\Schema\Blueprint;
//use Illuminate\Support\Facades\Schema;

//return new class extends Migration
//{
    /**
     * Run the migrations.
     */
  //  public function up(): void
    //{
      //  Schema::create('images', function (Blueprint $table) {
        //    $table->id();
          //  $table->timestamps();
       // });
    //}

    /**
     * Reverse the migrations.
     */
    //public function down(): void
    //{
      //  Schema::dropIfExists('images');
    //}
//};

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
        $table->id();
        $table->string('path'); // To store the image file path
        $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('images');
    }
}
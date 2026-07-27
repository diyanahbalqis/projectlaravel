<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->tinyInteger('approval')->default(0)->after('email'); // adjust position as needed
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('approval');
    });
}
};

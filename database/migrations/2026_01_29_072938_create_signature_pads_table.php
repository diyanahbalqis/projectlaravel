<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('signature_pads', function (Blueprint $table) {  // Changed to snake_case plural
            $table->id();
            $table->string('file_path');
            $table->string('type');  // e.g., 'drawn' or 'uploaded'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('signature_pads');
    }
};
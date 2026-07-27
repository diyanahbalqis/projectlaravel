<?php

use Illuminate\Database\Migrations\Migration; 
use Illuminate\Database\Schema\Blueprint; 
use Illuminate\Support\Facades\Schema; 


    return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            
            // User Information
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('staff_id')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('department')->nullable();
            $table->string('email')->nullable();
            
            // Loan Details
            $table->string('purpose')->nullable();
            $table->text('other_purpose')->nullable();
            $table->string('item_type')->nullable();
            $table->string('item')->nullable();
            $table->string('other_equipment')->nullable();
            $table->string('asset_no')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('serial_no')->nullable();
            $table->foreignId('equipment_id')->nullable()->constrained()->onDelete('set null');
            
            // Equipment Details
            $table->string('current_location')->nullable();
            $table->string('asset_serial_number')->nullable();
            $table->string('model')->nullable();
            $table->text('additional_description')->nullable();
            $table->string('condition')->nullable();
            
            // Dates
            $table->date('date_borrow')->nullable();
            $table->date('date_return')->nullable();
            $table->date('est_ret_date')->nullable();
            
            // Borrower Signature & Stamp
            $table->string('name_borrower')->nullable();
            $table->date('date_borrower')->nullable();
            $table->string('sign_borrower')->nullable(); // file path
            $table->string('stamp_borrower')->nullable(); // file path
            
            // Superior Approval
            $table->string('name_superior')->nullable();
            $table->date('date_superior')->nullable();
            $table->string('sign_superior')->nullable(); // file path
            
            // ICT Approval
            $table->string('name_ict')->nullable();
            $table->date('date_ict')->nullable();
            $table->string('sign_ict')->nullable(); // file path
            
            // Status
            $table->string('status')->default('Pending'); // Pending, Approved, Returned, Rejected
            
            $table->timestamps();

            // Indexes for better performance
            $table->index('user_id');
            $table->index('equipment_id');
            $table->index('status');
            $table->index('date_borrow');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};


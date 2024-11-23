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
        Schema::create('borrows', function (Blueprint $table) {
            $table->id(); // BIGINT AUTO_INCREMENT PRIMARY KEY
            $table->foreignId('member_id')->constrained('members')->onDelete('cascade'); // BIGINT FOREIGN KEY
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade'); // BIGINT FOREIGN KEY
            $table->dateTime('borrow_date');
            $table->dateTime('return_date')->nullable();
            $table->enum('status', ['OnGoing', 'OnTime', 'Late'])->default('OnGoing');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrows');
    }
};
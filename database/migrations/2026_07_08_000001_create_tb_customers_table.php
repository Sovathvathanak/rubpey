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
        Schema::create('tb_customers', function (Blueprint $table) {
            $table->increments('customer_id');
            $table->string('first_name', 20);
            $table->string('last_name', 20);
            $table->binary('Image');
            $table->string('password');
            $table->string('pin_number');
            $table->string('national_id', 20)->unique();
            $table->string('nationality', 20);
            $table->string('phone', 20)->unique();
            $table->string('email', 50);
            $table->text('address');
            $table->date('data_of_birth')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_customers');
    }
};

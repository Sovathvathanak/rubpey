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
        Schema::create('tb_accounts', function (Blueprint $table) {
            $table->increments('account_id');
            $table->unsignedInteger('customer_id');
            $table->string('account_type', 20);
            $table->string('account_number', 8);
            $table->decimal('balance', 12, 2)->default(0);
            $table->enum('status', ['Active', 'Frozen', 'Closed'])->default('Active');
            $table->string('currency', 15);
            $table->string('account_name', 50);

            $table->foreign('customer_id')
                ->references('customer_id')->on('tb_customers')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_accounts');
    }
};

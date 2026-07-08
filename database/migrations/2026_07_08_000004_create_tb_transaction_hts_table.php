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
        Schema::create('tb_transaction_hts', function (Blueprint $table) {
            $table->increments('transaction_id');
            $table->unsignedInteger('account_id');
            $table->unsignedInteger('transfer_id');
            $table->decimal('amount', 12, 2);
            $table->longText('description')->nullable();
            $table->dateTime('transfer_date');
            $table->enum('status', ['Completed', 'Processing', 'Failed']);

            $table->foreign('account_id')
                ->references('account_id')->on('tb_accounts')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('transfer_id')
                ->references('transfer_id')->on('tb_transfers')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_transaction_hts');
    }
};

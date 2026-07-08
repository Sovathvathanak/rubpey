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
        Schema::create('tb_transfers', function (Blueprint $table) {
            $table->increments('transfer_id');
            $table->unsignedInteger('from_account_id')->nullable();
            $table->unsignedInteger('to_account_id');
            $table->decimal('amount', 12, 2);
            $table->string('reference_code', 20)->unique();
            $table->dateTime('transfer_date');
            $table->enum('status', ['Pending', 'Completed', 'Failed']);

            $table->foreign('from_account_id')
                ->references('account_id')->on('tb_accounts')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('to_account_id')
                ->references('account_id')->on('tb_accounts')
                ->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_transfers');
    }
};

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
        Schema::create('transaction', function (Blueprint $table) {
            $table->increments('id_transaction');
            $table->timestamp('date_transaction')->nullable()->useCurrent();
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['WAITING_CONFIRMATION', 'PROCESS', 'SEND', 'FINISH', 'CANCEL'])->default('WAITING_CONFIRMATION');
            $table->string('method_payment', 50);
            $table->unsignedInteger('id_customer')->nullable();
            // No default Laravel timestamps

            $table->foreign('id_customer')
                ->references('id_customer')
                ->on('customer')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};

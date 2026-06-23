<?php

use App\Models\ExecutionExpense;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('execution_expense_items', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(ExecutionExpense::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->string('category');
            $table->string('item_name')->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('execution_expense_items');
    }
};
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
        Schema::create('technical__task__amounts', function (Blueprint $table) {
            $table->id();
            $table->integer('technical_id');
            $table->integer('task_id');
            $table->double('amount');
            $table->date('date');
            $table->integer('facture_id');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('technical__task__amounts');
    }
};

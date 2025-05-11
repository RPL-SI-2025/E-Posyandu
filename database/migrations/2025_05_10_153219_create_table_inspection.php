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
        Schema::create('table_inspection', function (Blueprint $table) {
            $table->id();
            $table->foreignId('table_child_id')->constrained('table_child')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal_pemeriksaan');
            $table->decimal('berat_badan', 8, 2);
            $table->decimal('tinggi_badan', 8, 2);
            $table->decimal('lingkar_kepala', 8, 2)->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('eventtime_id')->constrained('table_eventtime')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_inspection');
    }
};

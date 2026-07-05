<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema; // ← Pastikan ini Schema, BUKAN SSchema

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lapangans', function (Blueprint $table) { // ← Schema (bukan SSchema)
            $table->id();
            $table->string('nama');
            $table->string('jenis');
            $table->text('deskripsi')->nullable();
            $table->string('lokasi');
            $table->decimal('harga_per_jam', 15, 2);
            $table->enum('status', ['available', 'unavailable'])->default('available');
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lapangans');
    }
};
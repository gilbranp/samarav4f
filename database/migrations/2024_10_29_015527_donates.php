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
        Schema::create('donates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama donatur
            $table->string('phone'); // Nomor telepon donatur
            $table->string('donation_type'); // Jenis donasi
            $table->integer('amount')->nullable(); // Jumlah donasi (untuk uang)
            $table->string('item_name')->nullable(); // Nama barang (untuk donasi barang)
            $table->integer('item_qty')->nullable(); // Jumlah barang
            $table->date('expired_date')->nullable(); // Tanggal kadaluarsa (untuk donasi barang)
            $table->text('message')->nullable(); // Pesan dari donatur
            $table->timestamps(); // Tanggal dibuat dan diupdate
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

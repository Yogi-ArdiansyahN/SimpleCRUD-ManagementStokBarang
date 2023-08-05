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
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('kategori_id');
            $table->text('jumlah_barang');
            $table->text('harga');
            $table->text('total_harga');
            $table->timestamp('tanggal_penjualan');
            $table->timestamps();

            $table->foreign('kategori_id')->references('id')->on('kategori_barangs')->onDelete('cascade');
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penjualans');
    }
};

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
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('barang_id');
            $table->string('harga_beli');
            $table->string('jumlah_beli');
            $table->string('total_harga');
            $table->timestamp('tanggal_pembelian');
            $table->timestamps();

            $table->foreign('barang_id')->references('id')->on('barangs');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembelians');
    }
};

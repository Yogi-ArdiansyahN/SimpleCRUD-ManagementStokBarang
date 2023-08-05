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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id(); // Kolom ID secara otomatis akan ditambahkan dan menjadi primary key
            $table->string('nama_barang'); // Kolom untuk menyimpan nama barang (misalnya, tipe VARCHAR)
            $table->unsignedBigInteger('kategori_id'); // Kolom untuk menyimpan ID kategori (tipe data integer unsigned)
            $table->unsignedBigInteger('supplier_id'); // Kolom untuk menyimpan ID kategori (tipe data integer unsigned)
            $table->string('harga_modal')->nullable(); // Kolom untuk menyimpan harga barang (tipe data string)
            $table->string('harga_jual'); // Kolom untuk menyimpan harga barang (tipe data string)
            $table->string('stok_barang')->nullable(); // Kolom untuk menyimpan jumlah stok barang (tipe data integer)
            $table->timestamps(); // Kolom created_at dan updated_at akan secara otomatis diisi saat data ditambah atau diubah

            // Definisi hubungan dengan tabel Kategori Barang
            $table->foreign('kategori_id')->references('id')->on('kategori_barangs')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barangs');
    }
};

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Barang;
use App\Models\DetailPembelian;
use App\Models\DetailPenjualan;
use App\Models\KategoriBarang;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Crypt;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        KategoriBarang::factory()->state(new Sequence(['nama_kategori' => Crypt::encryptString('Smart Phone')]))->create();
        KategoriBarang::factory()->state(new Sequence(['nama_kategori' => Crypt::encryptString('Televisi')]))->create();
        KategoriBarang::factory()->state(new Sequence(['nama_kategori' => Crypt::encryptString('Laptop dan Komputer')]))->create();
        KategoriBarang::factory()->state(new Sequence(['nama_kategori' => Crypt::encryptString('Kamera Digital')]))->create();
        KategoriBarang::factory()->state(new Sequence(['nama_kategori' => Crypt::encryptString('Speaker')]))->create();

        // Barang::factory(10)->create();

        Supplier::factory()->state(new Sequence([
            'nama_supplier' => Crypt::encryptString('Ucok'),
            'brand_supplier' => Crypt::encryptString('Sony'),
            'alamat_supplier' => Crypt::encryptString('cikoe'),
            'kontak_supplier' => Crypt::encryptString('089876787765')
        ]))->create();

        Supplier::factory()->state(new Sequence([
            'nama_supplier' => Crypt::encryptString('Robert'),
            'brand_supplier' => Crypt::encryptString('Samsung'),
            'alamat_supplier' => Crypt::encryptString('cikaret'),
            'kontak_supplier' => Crypt::encryptString('089889876656')
        ]))->create();

        // Pembelian::factory(10)->create();

        // Penjualan::factory(10)->create();
    }
}

<?php

namespace Database\Factories;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Supplier;
use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pembelian>
 */
class PembelianFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $supp = Supplier::inRandomOrder()->first();
        $bar = Barang::inRandomOrder()->first();

        $timeZone = new CarbonTimeZone('Asia/Jakarta');
        $startDate = Carbon::createFromFormat('Y-m-d H:i', '2022-01-01 10:01');
        $endDate = Carbon::now($timeZone);
        $randDate = $this->faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d H:i');

        $randTotal = rand('10', '20');

        $totalPembelian = $randTotal * $bar->harga_barang;

        return [
            'supplier_id' => $supp->id,
            'kategori_barang_id' => $bar->kategori_id,
            'jumlah_pembelian_barang' => $randTotal,
            'tanggal_pembelian' => $randDate,
            'total_harga_pembelian' => $totalPembelian,
            'harga_satuan_barang' => $bar->harga_barang,
            'barang_id' => $bar->id,
        ];
    }
}

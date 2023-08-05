<?php

namespace Database\Factories;

use App\Models\Barang;
use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penjualan>
 */
class PenjualanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bar = Barang::inRandomOrder()->first();

        $jumlah = rand('1', '15');

        $timeZone = new CarbonTimeZone('Asia/Jakarta');
        $startDate = Carbon::createFromFormat('Y-m-d H:i', '2022-01-01 10:01');
        $endDate = Carbon::now($timeZone);
        $randDate = $this->faker->dateTimeBetween($startDate, $endDate)->format('Y-m-d H:i');

        return [
            'barang_id' => $bar->id,
            'kategori_barang_id' => $bar->kategori_id,
            'jumlah_barang' => $jumlah,
            'harga_satuan' => $bar->harga_barang,
            'total_harga_barang' => $jumlah * $bar->harga_barang,
            'tanggal_penjualan' => $randDate
        ];
    }
}

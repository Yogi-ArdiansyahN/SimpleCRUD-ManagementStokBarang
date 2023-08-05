<?php

namespace Database\Factories;

use App\Models\KategoriBarang;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kategori = KategoriBarang::inRandomOrder()->first();
        $BarangRandom = ['Nokia E110', 'Nokia A1A49', 'LG E19', 'Samsung Ultra-17', 'HP A-11231', 'Acer Univers-112', 'Cannon B4131', 'Sony E3000', 'LG Audio-199', 'Simbadda A600'];

        $minRange = 200000;
        $maxRange = 10000000;
        $steps = [5000, 10000, 15000, 20000, 25000];
        // Pilih langkah acak dari array $steps
        $randomStep = $steps[array_rand($steps)];
        // Hasil keluaran acak dengan langkah yang dipilih
        $randNominal = rand($minRange, $maxRange);
        $randNominal = floor($randNominal / $randomStep) * $randomStep;
        if ($randNominal < 10000) {
            $nominal = $minRange;
        } else {
            $nominal = $randNominal;
        }

        $minrange = 2;
        $maxrang = 10;
        $stok = rand($minrange, $maxrang);

        return [
            'nama_barang' => $this->faker->randomElement($BarangRandom),
            'kategori_id' => $kategori->id,
            'harga_barang' => $nominal,
            'jumlah_stok_barang' => $stok
        ];
    }
}

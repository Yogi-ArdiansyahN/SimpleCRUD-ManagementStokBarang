<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'pembelians';
    protected $primaryKey = 'id';
    protected $fillable = [
        'barang_id',
        'jumlah_beli',
        'harga_beli',
        'total_harga',
        'tanggal_pembelian',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'suppliers';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_supplier',
        'alamat_supplier',
        'kontak_supplier',
        'brand_supplier'
    ];

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'supplier_id');
    }
}

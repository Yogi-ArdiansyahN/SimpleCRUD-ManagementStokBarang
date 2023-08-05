<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBarang extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'kategori_barangs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_kategori',
        'deskripsi_kategori',
    ];
}

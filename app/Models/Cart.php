<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Cart extends Model
{
    use HasUlids, HasFactory;

    protected $fillable = ['user_id', 'product_id', 'quantity'];

    // Relasi ke Produk (Supaya bisa ambil Nama, Harga, Gambar)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    // Relasi ke User (Opsional, buat jaga-jaga)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Category extends Model
{
    use HasUlids, HasFactory;

    protected $fillable = ['name', 'slug', 'icon'];

    // Relasi: Satu Kategori punya Banyak Produk
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
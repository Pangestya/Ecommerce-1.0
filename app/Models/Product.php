<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Product extends Model
{
    use HasUlids, HasFactory;

    protected $fillable = [
        'user_id', 'updated_by','category_id',
        'name', 'description', 'price', 'stock',
        'weight', 'length', 'width', 'height', // <--- Data Pengiriman
        'image', 
        'is_active', 'is_featured',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function editor() { return $this->belongsTo(User::class, 'updated_by'); }

    // Relasi ke tabel images 
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    #relasi ke tabel kateogori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class)->latest();
    }

    public function averageRating() {
        return $this->reviews()->avg('rating') ?: 0;
    }
}
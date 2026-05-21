<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class ProductImage extends Model
{
    use HasUlids, HasFactory;

    protected $fillable = ['product_id', 'image_path'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
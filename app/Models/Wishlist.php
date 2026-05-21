<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Wishlist extends Model
{
    use HasUlids, HasFactory;
    
    protected $fillable = ['user_id', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
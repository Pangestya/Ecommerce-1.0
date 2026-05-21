<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class OrderItem extends Model
{
    use HasUlids, HasFactory;

    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
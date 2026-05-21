<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Alamat extends Model
{
    use HasUlids, HasFactory;

    protected $table = 'alamats';

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'province_id',
        'province_name',
        'city_id',
        'city_name',
        'subdistrict_id',
        'subdistrict_name',
        'village_id',
        'village_name',
        'postal_code',
        'detail_alamat',
        'is_primary'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
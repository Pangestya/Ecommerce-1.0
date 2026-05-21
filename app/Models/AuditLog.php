<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class AuditLog extends Model
{
    use HasUlids, HasFactory;

    protected $fillable = ['user_id', 'action', 'model_type', 'model_name', 'details'];

    // Relasi ke User (Pelaku)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
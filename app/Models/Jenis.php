<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jenis extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul'
    ];

    public function jenisorder(): HasMany
    {
        return $this->hasMany(JenisOrder::class);
    }
}

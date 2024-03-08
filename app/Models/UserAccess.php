<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'access'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

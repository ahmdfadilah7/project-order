<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'pelanggan_id',
        'penjoki_id'
    ];

    /**
     * Get all of the chat for the Group
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chat(): HasMany
    {
        return $this->hasMany(ChatGroup::class);
    }

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penjoki_id', 'id');
    }

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pelanggan_id', 'id');
    }
}

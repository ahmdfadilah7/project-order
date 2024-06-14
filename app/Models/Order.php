<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pelanggan_id',
        'bobot_id',
        'judul',
        'deskripsi',
        'keterangan',
        'deadline',
        'total',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pelanggan_id', 'id');
    }

    public function activity(): HasOne
    {
        return $this->hasOne(Activity::class)->orderBy('created_at', 'desc');
    }

    public function jenisorder(): HasMany
    {
        return $this->hasMany(JenisOrder::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class)->orderBy('created_at', 'desc');
    }

    public function refund(): HasMany
    {
        return $this->hasMany(Refund::class)->orderBy('created_at', 'desc');
    }

    public function bobot(): BelongsTo
    {
        return $this->belongsTo(Bobot::class);
    }
    
}

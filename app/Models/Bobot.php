<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bobot extends Model
{
    use HasFactory;

    protected $fillable = [
        'bobot'
    ];

    /**
     * Get the order associated with the Bobot
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }
}

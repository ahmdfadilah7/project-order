<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'file',
        'keterangan'
    ];
}

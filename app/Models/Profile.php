<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'no_telp',
        'tmpt_lahir',
        'tgl_lahir',
        'jns_kelamin',
        'jurusan',
        'daerah',
    ];
}

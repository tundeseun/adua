<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prayer extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_path',
        'text',
        'prayer_type',
        'user_id',
    ];
}

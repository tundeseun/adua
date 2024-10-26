<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimony extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_path',
        'text',
        'testimony_type',
        'user_id',
    ];
}
